<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'billing_email',
        'billing_name',
        'billing_address',
        'billing_country',
        'billing_city',
        'billing_postalcode',
        'billing_phone',
        'billing_name_on_card',
        'billing_discount',
        'billing_discount_code',
        'billing_subtotal',
        'billing_tax',
        'billing_total',
        'error',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    // many to many relationship
    public function books()
    {
        return $this->belongsToMany('App\Book')->withPivot('quantity');
    }
}
