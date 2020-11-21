<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use \App\Models\Asn;
use \App\Models\NetIxLan;
use \App\Models\Ix;


class AsnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        set_time_limit(0);
        \Log::notice('        =/\                 /\=');
        \Log::notice('        / \`._   (\_/)   _.`/ \\');
        \Log::notice('       / .``._`--(o.o)--`_.``. \\');
        \Log::notice('      /.` _/ |``=/ " \=``| \_ `.\\');
        \Log::notice('     /` .` `\;-,`\___/`,-;/` `. `\\');
        \Log::notice('    /.-` INIT  `\(-V-)/`       `-.\\');
        \Log::notice('    `            "   "');
        $response = Http::timeout(0)->get('https://www.peeringdb.com/api/net');
        $list_asn = array_reverse(json_decode($response->body(),true)['data']);

        \Log::notice("ASN TOTAL: ".count($list_asn));
        foreach($list_asn as $asn){
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
            \Log::notice("####### {$asn['id']}");
        }
        \Log::error('END');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        set_time_limit(0);
        \Log::notice('        =/\                 /\=');
        \Log::notice('        / \`._   (\_/)   _.`/ \\');
        \Log::notice('       / .``._`--(o.o)--`_.``. \\');
        \Log::notice('      /.` _/ |``=/ " \=``| \_ `.\\');
        \Log::notice('     /` .` `\;-,`\___/`,-;/` `. `\\');
        \Log::notice('    /.-` INIT  `\(-V-)/`       `-.\\');
        \Log::notice('    `            "   "');
        $response = Http::timeout(0)->get('https://www.peeringdb.com/api/netixlan');
        $list_ix = array_reverse(json_decode($response->body(),true)['data']);

        \Log::notice("ix TOTAL: ".count($list_ix));
        foreach($list_ix as $ix){
            $ix_data = [
                'out_id' => $ix['id'],
                'out_net_id' => $ix['net_id'],
                'out_ix_id' => $ix['ix_id'],
                'out_ixlan_id' => $ix['ixlan_id'],
                'out_asn' => $ix['asn'],
                'out_create' => str_replace('Z','',str_replace('T',' ',$ix['created'])),
                'out_update' => str_replace('Z','',str_replace('T',' ',$ix['updated']))
            ];
            Ix::updateOrCreate(['out_id' => $ix_data['out_id']],\Arr::except($ix_data, ['out_id']));
            \Log::notice("####### {$ix['id']}");
        }
        \Log::error('END');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        set_time_limit(0);
        \Log::notice('        =/\                 /\=');
        \Log::notice('        / \`._   (\_/)   _.`/ \\');
        \Log::notice('       / .``._`--(o.o)--`_.``. \\');
        \Log::notice('      /.` _/ |``=/ " \=``| \_ `.\\');
        \Log::notice('     /` .` `\;-,`\___/`,-;/` `. `\\');
        \Log::notice('    /.-` INIT  `\(-V-)/`       `-.\\');
        \Log::notice('    `            "   "');
        $response = Http::timeout(0)->get('https://www.peeringdb.com/api/netixlan');
        $list_net_ix_lan = array_reverse(json_decode($response->body(),true)['data']);

        \Log::notice("NET_IX_LAN TOTAL: ".count($list_net_ix_lan));
        foreach($list_net_ix_lan as $net_ix_lan){
            $net_ix_lan_data = [
                'out_id' => $net_ix_lan['id'],
                'out_org_id' => $net_ix_lan['org_id'],
                'out_name' => $net_ix_lan['name'],
                'out_city' => $net_ix_lan['city'],
                'out_country' => $net_ix_lan['country'],
                'out_region_continent' => $net_ix_lan['region_continent'],
                'out_create' => str_replace('Z','',str_replace('T',' ',$net_ix_lan['created'])),
                'out_update' => str_replace('Z','',str_replace('T',' ',$net_ix_lan['updated']))
            ];
            NetIxLan::updateOrCreate(['out_id' => $net_ix_lan_data['out_id']],\Arr::except($net_ix_lan_data, ['out_id']));
            \Log::notice("####### {$net_ix_lan['id']}");
        }
        \Log::error('END');
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
