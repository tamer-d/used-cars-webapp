<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->unsignedInteger('year');
            $table->unsignedInteger('mileage'); // kilométrage
            $table->enum('fuel_type', ['diesel', 'essence', 'électrique', 'hybride', 'gpl']);
            $table->enum('transmission', ['manuelle', 'automatique', 'semi-automatique']);
            $table->foreignId('brand_id')->constrained();
            $table->foreignId('model_id')->constrained('car_models');
            $table->foreignId('category_id')->constrained();
            $table->string('color');
            $table->unsignedSmallInteger('doors')->default(5);
            $table->string('engine_size')->nullable();
            $table->unsignedInteger('power')->nullable(); // puissance en CV
            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('views_count')->default(0);
            $table->string('location'); // ville ou région
            $table->timestamps();
            
            // Index pour les recherches fréquentes
            $table->index(['brand_id', 'model_id', 'year']);
            $table->index(['price', 'status']);
            $table->index(['fuel_type', 'transmission']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};