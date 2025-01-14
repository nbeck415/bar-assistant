<?php

declare(strict_types=1);

namespace Kami\Cocktail\Http\Controllers;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Kami\Cocktail\Models\UserShoppingList;
use Illuminate\Http\Resources\Json\JsonResource;
use Kami\Cocktail\Http\Resources\SuccessActionResource;
use Kami\Cocktail\Http\Resources\UserShoppingListResource;

class ShoppingListController extends Controller
{
    public function index(Request $request): JsonResource
    {
        return UserShoppingListResource::collection(
            $request->user()->shoppingList->load('ingredient')
        );
    }

    public function batchStore(Request $request): JsonResource
    {
        $ingredientIds = $request->post('ingredient_ids');

        $models = [];
        foreach ($ingredientIds as $ingId) {
            $usl = new UserShoppingList();
            $usl->ingredient_id = $ingId;
            try {
                $models[] = $request->user()->shoppingList()->save($usl);
            } catch (Throwable) {
            }
        }

        return UserShoppingListResource::collection($models);
    }

    public function batchDelete(Request $request): JsonResource
    {
        $ingredientIds = $request->post('ingredient_ids');

        try {
            $request->user()->shoppingList()->whereIn('ingredient_id', $ingredientIds)->delete();
        } catch (Throwable $e) {
            abort(500, $e->getMessage());
        }

        return new SuccessActionResource((object) ['ingredient_ids' => $ingredientIds]);
    }

    public function share(Request $request): Response
    {
        $type = $request->get('type', 'markdown');

        $shoppingListIngredients = $request->user()
            ->shoppingList
            ->load('ingredient.category')
            ->groupBy('ingredient.category.name');

        if ($type === 'markdown' || $type === 'md') {
            return new Response(
                view('md_shopping_list_template', compact('shoppingListIngredients'))->render(),
                200,
                ['Content-Type' => 'text/markdown']
            );
        }

        abort(400, 'Requested type "' . $type . '" not supported');
    }
}
