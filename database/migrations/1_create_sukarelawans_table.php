<?php

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
        Schema::create('sukarelawans', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string("name");
            $table->integer("experiencePoint");
            $table->integer("level");
            $table->string("email")->unique();
            $table->string("password");
            $table->string("picture");
            $table->string("nationalIdentityNumber")->unique();
            $table->string("identityCardPicture");
            $table->string("gender");
            $table->string("status"); // check verifikasi KTP
            $table->date("dateOfBirth");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sukarelawans');
    }
};
