<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use \App\Models\Asn;

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
        $response = Http::timeout(0)->get('https://www.peeringdb.com/api/ix');
        $list_ix = json_decode($response->body(),true)['data'];
        return response()->json($list_ix);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
