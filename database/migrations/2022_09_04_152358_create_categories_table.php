<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\Types\Nullable;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
           $table->id();//primary key
           $table->string('name',255);//varchar
           $table->string('slug')->unique();
           $table->foreignId('parent_id')->nullable()->constrained('categories','id')->nullOnDelete();//must be accept null to define it nullondelete

           /*
           another method to define foreignkey
           $table->unsignedBigInteger('parent_id')->nullable();
           $table->foreign('parent_id')->references('id')->on('categories')->cascadeOnDelete();
         */
          $table->text('description')->nullable();
          $table->string('image_path')->nullable();//path of image in file system
          $table->enum('status',['active','draft']);
          $table->timestamps();//created_at and start_at colum


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
