<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        /*
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->id(); // Kolom ID auto increment
            $table->string('email')->index(); // Kolom email yang di-reset (dapat diindeks)
            $table->string('token'); // Kolom token untuk reset password
            $table->timestamp('created_at')->nullable(); // Waktu saat token dibuat
        });
        */
    }

    public function down()
    {
        #Schema::dropIfExists('password_reset_tokens');
    }

};
