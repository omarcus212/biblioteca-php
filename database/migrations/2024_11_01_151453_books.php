<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('publisher', function (Blueprint $table) {
            $table->id()->primary()->autoIncrement()->unsigned();
            $table->string('name', 60);
            $table->string('image', 200)->nullable();
        });

        Schema::create('books', function (Blueprint $table) {
            $table->id()->primary()->autoIncrement()->unsigned();
            $table->string('name', 30);
            $table->string('ISBN', 13);
            $table->float('price');
            $table->string('image', 200)->nullable();
            $table->text('bibliography');
            $table->unsignedBigInteger('id_publisher');
            $table->foreign('id_publisher')->references('id')->on('publisher');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
