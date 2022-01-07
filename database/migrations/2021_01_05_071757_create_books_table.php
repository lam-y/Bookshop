<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('author');
            $table->string('image')->nullable()            ;
            $table->text('description')->nullable();
            $table->string('publisher')->nullable();
            $table->integer('pages')->nullable();
            $table->float('price')->nullable();
            $table->timestamps();
        });

        Artisan::call('db:seed', [
            '--class' => BooksTableSeeder::class
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
}
