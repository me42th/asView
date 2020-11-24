<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AsViewController extends Controller
{
    public function index(Request $request){
        set_time_limit(0);
        $asn = \DB::table('asn')->select(['out_asn','out_name','out_policy_general']);
        $condition = '';
        if(\Request::has('q')){
            $condition = $request->query('q');
            $asn->where('out_asn',$condition)
                ->orWhere('out_name','like',"%$condition%");

        }
        $msg = '';
        $list_ix = [];
        if(\Request::has('asn')){
            $asn_id = $request->query('asn');
            $sql = "select asn.out_name as org, ix.out_name, ix.out_city, out_country, out_region_continent
                from asn
                    join net_ix_lan as pivot
                        on pivot.out_asn = asn.out_asn
                    join ix
                        on pivot.out_ix_id = ix.out_id
                where asn.out_asn = '$asn_id'
                group by ix.out_name, asn.out_name, out_city, out_country, out_region_continent;";
            $list_ix = \DB::select($sql);
            $name = (\DB::select("select out_name from asn where out_asn = '$asn_id';"))[0]->out_name;
            if(!$list_ix){
                $msg = "Nenhum IX encontrado para o ASN $name";
            }
        }

        $asn_a = null;
        $org_a = null;
        if(\Request::has('asn_a')){
            $asn_a = $request->query('asn_a');
            try{
                $org_a = (\DB::select("select out_name from asn where out_asn = '$asn_a';"))[0]->out_name;
            } catch(\Exception $ex){
                $org_a = null;
            }
        }

        $asn_b = null;
        $org_b = null;
        if(\Request::has('asn_b')){
            $asn_b = $request->query('asn_b');
            try{
                $org_b = (\DB::select("select out_name from asn where out_asn = '$asn_b';"))[0]->out_name;
            } catch(\Exception $ex){
                $org_b = null;
            }
        }

        $intersection = null;
        $union = null;
        $only_a = [];
        $only_b = [];
        $all_a = [];
        $all_b = [];
        if(!($asn_a xor $asn_b))
        {
            $sql = "select tabela.out_name, tabela.out_city, tabela.out_country, tabela.out_region_continent from
            (
                select ix.out_name, ix.out_city, out_country, out_region_continent
                from asn
                    join net_ix_lan as pivot
                        on pivot.out_asn = asn.out_asn
                    join ix
                        on pivot.out_ix_id = ix.out_id
                where asn.out_asn = '$asn_a'
            ) as tabela
                join (
                    select ix.out_name, ix.out_city, out_country, out_region_continent
                    from asn
                        join net_ix_lan as pivot
                            on pivot.out_asn = asn.out_asn
                        join ix
                            on pivot.out_ix_id = ix.out_id
                    where asn.out_asn = '$asn_b'
            ) as tabela2
            on tabela.out_name = tabela2.out_name
            group by tabela.out_name, tabela.out_city, tabela.out_country, tabela.out_region_continent;";
            $intersection = \DB::select($sql);

            $sql = "select ix.out_name, ix.out_city, ix.out_country, ix.out_region_continent
                    from asn
                        join net_ix_lan as pivot
                            on pivot.out_asn = asn.out_asn
                        join ix
                            on pivot.out_ix_id = ix.out_id
                    where asn.out_asn = '$asn_a'
                    union
                    select ix.out_name, ix.out_city, out_country, out_region_continent
                        from asn
                            join net_ix_lan as pivot
                                on pivot.out_asn = asn.out_asn
                            join ix
                                on pivot.out_ix_id = ix.out_id
                    where asn.out_asn = '$asn_b';";
            $union = \DB::select($sql);

            $sql = "
                select ix.out_name, ix.out_city, ix.out_country, ix.out_region_continent
                from asn
                    join net_ix_lan as pivot
                        on pivot.out_asn = asn.out_asn
                    join ix
                        on pivot.out_ix_id = ix.out_id
                where asn.out_asn = '$asn_a'
                group by ix.out_name, ix.out_city, out_country, out_region_continent;";
            $all_a = \DB::select($sql);

            $sql = "
                select ix.out_name, ix.out_city, ix.out_country, ix.out_region_continent
                from asn
                    join net_ix_lan as pivot
                        on pivot.out_asn = asn.out_asn
                    join ix
                        on pivot.out_ix_id = ix.out_id
                where asn.out_asn = '$asn_b'
                group by ix.out_name, ix.out_city, out_country, out_region_continent;";
            $all_b = \DB::select($sql);

            foreach($all_a as $item_a){
                $flag = true;
                foreach($all_b as $item_b)
                    if($item_a->out_name == $item_b->out_name) $flag = false;
                if($flag){
                    $only_a[] = $item_a;
                }
            }

            foreach($all_b as $item_b){
                $flag = true;
                foreach($all_a as $item_a)
                    if($item_a->out_name == $item_b->out_name) $flag = false;
                if($flag){
                    $only_b[] = $item_b;
                }
            }
        }

        $asn = $asn->limit(100)->orderBy('out_name')->paginate(100);
        return view('welcome')->with(compact('asn','intersection','union','org_a','org_b','only_a','only_b','all_a','all_b','list_ix','msg'));
    }
}
