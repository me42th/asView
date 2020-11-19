<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asn extends Model
{
    use HasFactory;
    protected $fillable = [
        'out_id',
        'out_org_id',
        'out_name',
        'out_asn',
        'out_policy_general',
        'out_create',
        'out_update'
    ];
    protected $table = 'asn';
}
