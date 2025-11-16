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
    Schema::table('products', function (Blueprint $table) {
        // 1. Add the column
        $table->foreignId('category_id') // Creates an unsignedBigInteger
              ->nullable()               // Allow products to have no category
              ->after('id')              // Place it after the 'id' column for cleanliness
              ->constrained('categories') // Set it as a foreign key to the 'id' on 'categories' table
              ->onDelete('set null');    // If a category is deleted, set product's category_id to NULL
    });
}

public function down(): void
{
    Schema::table('products', function (Blueprint $table) {
        // This is the reverse operation for rollbacks
        $table->dropForeign(['category_id']);
        $table->dropColumn('category_id');
    });
}

    };
