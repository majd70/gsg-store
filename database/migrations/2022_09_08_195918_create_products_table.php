<?php

use App\Models\product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rules\Unique;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->foreignId('category_id')->constrained('categories','id')->restrictOnDelete();
            $table->text('description')->nullable();
            $table->string('image_path')->nullable();
            $table->float('price')->default(0);
            $table->float('sale_price')->nullable()->default(0);
            $table->unsignedSmallInteger('quantity')->nullable()->default(0);
            $table->string('sku')->unique()->nullable();
            $table->unsignedFloat('weight')->nullable();
            $table->unsignedFloat('width')->nullable();
            $table->unsignedFloat('height')->nullable();
            $table->unsignedFloat('length')->nullable();
            $table->enum('status',[product::STATUS_ACTIVE,product::STATUS_DRAFT]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
