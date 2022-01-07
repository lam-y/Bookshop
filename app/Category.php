<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = "categories";


    /**
     * One To Many relationship
     * and it means this category has many book
     * and it will return all books related to this category
     */
    public function books(){
        return $this->hasMany('App\Book');
    }
}
