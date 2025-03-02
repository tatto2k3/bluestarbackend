<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{

    protected $table = 'discount';
    public $timestamps = false;
    protected $primaryKey = 'D_ID';
    public $incrementing = false;


    protected $fillable = [
        'D_ID', 'D_NAME', 'D_START', 'D_FINISH', 'D_PERCENT'
    ];
}
