<?php

use Illuminate\Support\Str;

function calculateDiscount($price, $discount)
{
    return $price - ($price * ($discount) / 100);
}

function countWords($sentence){
    return Str::of($sentence)->wordCount(); 
    
}