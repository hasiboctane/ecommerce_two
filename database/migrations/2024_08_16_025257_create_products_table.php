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
            $table->foreignId('parent_category_id')->nullable()->constrained('parent_categories')->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained('categories')->cascadeOnDelete();
            $table->foreignId('sub_category_id')->nullable()->constrained('sub_categories')->cascadeOnDelete();
            $table->foreignId('product_type_id')->nullable()->constrained('product_types')->cascadeOnDelete();
            $table->foreignId('brand_id')->nullable()->constrained('brands')->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->json('images')->nullable();
            $table->longText('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->boolean('in_stock')->default(true);
            $table->boolean('on_sale')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['parent_category_id']);
            $table->dropForeign(['category_id']);
            $table->dropForeign(['sub_category_id']);
            $table->dropForeign(['product_type_id']);
            $table->dropForeign(['brand_id']);
        });
        Schema::dropIfExists('products');
    }
};
