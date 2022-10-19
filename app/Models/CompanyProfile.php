<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyProfile extends Model
{
    use HasFactory;
    protected $table = "tbl_company";
    protected $primaryKey = "Company_SlNo";
    protected $guarded = ['id'];
}