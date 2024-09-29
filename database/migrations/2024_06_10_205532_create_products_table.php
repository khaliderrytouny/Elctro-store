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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug', 191)->unique();
            $table->string('description');
            $table->decimal('price', 8, 2)->default(0);
            $table->decimal('old_price', 8, 2)->default(0); 
            $table->string('image');
            $table->unsignedBigInteger('catigory_id'); 
            $table->timestamps();

            $table->foreign('catigory_id') 
                  ->references('id')
                  ->on('catigories')
                  ->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
