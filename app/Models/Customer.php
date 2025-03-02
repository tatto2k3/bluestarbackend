<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

    protected $table = 'customer';
    public $timestamps = false;
    protected $primaryKey = 'C_ID';
    public $incrementing = false;


    protected $fillable = [
        'C_ID', 'NUM_ID', 'FULLNAME', 'POINT', 'MAIL'
    ];
}
