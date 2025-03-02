<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plane extends Model
{

    protected $table = 'plane';
    public $timestamps = false;
    protected $primaryKey = 'PL_ID';
    public $incrementing = false;


    protected $fillable = [
        'PL_ID', 'TYPEOFPLANE', 'BUSINESS_CAPACITY', 'ECONOMY_CAPACITY'
    ];
}
