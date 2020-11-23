<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use \App\Models\Asn;
use \App\Models\NetIxLan;
use \App\Models\Ix;


class AsnController extends Controller
{

    public function fetchAsn(){
        set_time_limit(0);
        $response = Http::timeout(0)->get('https://www.peeringdb.com/api/net');
        $this->asn = array_reverse(json_decode($response->body(),true)['data']);
    }

    public function fetchNetIxLan(){
        set_time_limit(0);
        $response = Http::timeout(0)->get('https://www.peeringdb.com/api/netixlan');
        $this->net_ix_lan = json_decode($response->body(),true)['data'];
    }

    public function fetchIx(){
        set_time_limit(0);
        $response = Http::timeout(0)->get('https://www.peeringdb.com/api/ix');
        $this->ix = json_decode($response->body(),true)['data'];
    }

    public $asn,$ix,$net_ix_lan;
    public function index($asn)
    {
        $asn_data = [
            'out_id' => $asn['id'],
            'out_org_id' => $asn['org_id'],
            'out_name' => $asn['name'],
            'out_asn' => $asn['asn'],
            'out_policy_general' => $asn['policy_general'],
            'out_create' => str_replace('Z','',str_replace('T',' ',$asn['created'])),
            'out_update' => str_replace('Z','',str_replace('T',' ',$asn['updated']))
        ];
        Asn::updateOrCreate(['out_id' => $asn_data['out_id']],\Arr::except($asn_data, ['out_id']));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($net_ix_lan)
    {
    $net_ix_lan_data = [
        'out_id' => $net_ix_lan['id'],
        'out_net_id' => $net_ix_lan['net_id'],
        'out_ix_id' => $net_ix_lan['ix_id'],
        'out_ixlan_id' => $net_ix_lan['ixlan_id'],
        'out_asn' => $net_ix_lan['asn'],
        'out_create' => str_replace('Z','',str_replace('T',' ',$net_ix_lan['created'])),
        'out_update' => str_replace('Z','',str_replace('T',' ',$net_ix_lan['updated']))
    ];
    NetIxLan::updateOrCreate(['out_id' => $net_ix_lan_data['out_id']],\Arr::except($net_ix_lan_data, ['out_id']));
 }

    public function update($ix)
    {
        $ix_data = [
            'out_id' => $ix['id'],
            'out_org_id' => $ix['org_id'],
            'out_name' => $ix['name'],
            'out_city' => $ix['city'],
            'out_country' => $ix['country'],
            'out_region_continent' => $ix['region_continent'],
            'out_create' => str_replace('Z','',str_replace('T',' ',$ix['created'])),
            'out_update' => str_replace('Z','',str_replace('T',' ',$ix['updated']))
        ];
        Ix::updateOrCreate(['out_id' => $ix_data['out_id']],\Arr::except($ix_data, ['out_id']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        set_time_limit(0);
        $response = Http::timeout(0)->get('https://www.peeringdb.com/api/ix');
        $list_ix = json_decode($response->body(),true)['data'];
        \Log::error(print_r($list_ix,true));
        return response()->json($list_ix);
    }
}
