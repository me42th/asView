<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ix extends Model
{
    use HasFactory;
    protected $table = 'ix' ;
    protected $fillable = [
        'out_id',
        'out_org_id',
        'out_name',
        'out_city',
        'out_country',
        'out_region_continent',
        'out_create',
        'out_update'
    ];
}
