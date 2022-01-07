<?php 

use Carbon\Carbon;



function presentPrice($price)
{
    return number_format('$%i', $price / 100);
}



function presentDate($date)
{
    return Carbon::parse($date)->format('M d, Y');
}