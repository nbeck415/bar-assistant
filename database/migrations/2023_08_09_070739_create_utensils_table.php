<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('utensils', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('cocktail_utensil', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cocktail_id')->constrained()->onDelete('cascade');
            $table->foreignId('utensil_id')->constrained()->onDelete('cascade');
        });

        DB::table('utensils')->insert([
            ['name' => 'Mixing glass', 'description' => 'A glass with a heavy base that doesn\'t tip over when stirring.'],
            ['name' => 'Shaker', 'description' => 'A recipient in 2 parts to shake cocktails vigorously.'],
            ['name' => 'Bar spoon', 'description' => 'A long and heavy spiraled spoon used to stir or layer cocktails.'],
            ['name' => 'Julep Strainer', 'description' => 'A style of strainer used when using a mixing glass to strain the ice out.'],
            ['name' => 'Hawthorne Strainer', 'description' => 'A style of strainer used when using a shaker to strain the ice out.'],
            ['name' => 'Mesh Strainer', 'description' => 'A simple mesh strainer used to double strain cocktails in order to avoid any ice in the final drink, or to avoid pulp when juicing fruits.'],
            ['name' => 'Atomizer', 'description' => 'Refillable glass spray bottle to spray and mist very small amounts of aromatics. Used for absinthe rinses, and bitter sprays.'],
            ['name' => 'Muddler', 'description' => 'Essential tool to crush fruits, berries and herbs and extract the juice out of them.'],
            ['name' => 'Jigger', 'description' => 'Small cup used to quickly measure volumes in the bar.'],
            ['name' => 'Zester', 'description' => 'Rasp used to zest fruits, nuts, or even chocolate for garnishes.'],
            ['name' => 'Channel knife', 'description' => 'Knife designed to make long and thin citrus peels.'],
            ['name' => 'Y Peeler', 'description' => 'Kitchen tool designed to peel fruits and vegetables. In the bar, used for large peels to extract the oils from.'],
            ['name' => 'Bar knife', 'description' => 'A small sharp knife to peel and cut fruits.'],
            ['name' => 'Ice carving knife', 'description' => 'A knife with a significantly tougher spine designed to handle ice carving.'],
            ['name' => 'Ice chipper', 'description' => 'A three-pronged tool to chip away and break ice.'],
            ['name' => 'Ice pick', 'description' => 'A pick to break and chip away at ice.'],
            ['name' => 'Cocktail smoker', 'description' => 'A device used to add smokey flavor to cocktails by burning different wood escences.'],
            ['name' => 'Juicer', 'description' => 'Extract juice from citrus fruits.'],
            ['name' => 'Straight tongs', 'description' => 'Small precision tongs to place garnishes.'],
            ['name' => 'Ice tongs', 'description' => 'Tongs made to grab ice cubes.'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cocktail_utensil');
        Schema::dropIfExists('utensils');
    }
};
