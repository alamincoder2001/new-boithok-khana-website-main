<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable 
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['*'];
    protected $primaryKey = "Customer_SlNo";
    protected $table = "tbl_customer";
}