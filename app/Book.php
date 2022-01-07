<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = "books";

    protected $fillable = ['name', 'author','description','publisher', 'pages','image', 'created_at', 'updated_at'];


    
    public function presentPrice(){
        //return money_format('$xi', $this->price / 100);
        // المفروض هالتابع يعمل تنسيق للسعر، ونستخدمه بدال ما نكتب السعر كنص عادي، بس للأسف طلع ما بيشتغل مع ويندوز، ما بعرف كيف يعني
        // لذلك عملت تنسيق لحالي واستعملت تعليمة تانية بحيث تطبع الرقم العشري مو بس الصحيح
        return number_format($this->price, 2, ".", '');
    }

    /**
     * One To Many relationship
     * it means that this book related to or belongs to one category
     * and it will retrieve the category of this book
     */
    public function category(){
        return $this->belongsTo('App\Category');
    }


    // // انا اضفته
    // public function order(){         
    //     return $this->belongsTo('App\Order');
    // }
    
}
