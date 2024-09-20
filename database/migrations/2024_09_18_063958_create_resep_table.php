<?php

use App\Models\resep;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reseps', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('alat');
            $table->string('bahan');
            $table->string('pembuatan');
            $table->timestamps();
            $table->softDeletes();
        });
        $faker = \faker\Factory::create();
        resep::create([
            'name'=>$faker->word,
            'alat'=>$faker->word,
            'bahan'=>$faker->bothify('???###'),
            'pembuatan'=>$faker->sentence(5,true)
        ]);



    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reseps');
    }
};
