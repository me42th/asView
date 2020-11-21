<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NetIxLan extends Model
{
    use HasFactory;
    protected $table = 'net_ix_lan';
    protected $fillable = [
        'out_id',
        'out_net_id',
        'out_ix_id',
        'out_ixlan_id',
        'out_asn',
        'out_create',
        'out_update'
    ];
}
