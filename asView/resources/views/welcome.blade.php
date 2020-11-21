@extends('adminlte::page')

@section('title', 'Dashboard')


@section('content')

    <!-- /.row -->
    </div><!-- /.container-fluid -->
        <!-- Default box -->
        <div class="card">

          <div class="card-body">
            <div class="row">
              <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
                <div class="row">


                </div>
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0" style="height: 300px;">
                      <table class="table table-head-fixed text-nowrap">
                        <thead>
                          <tr>
                            <th>ASN</th>
                            <th>Organização</th>
                            <th>Política</th>
                          </tr>
                        </thead>
                        <tbody>
                        @foreach($asn as $a)
                          <tr>
                            <td>{{$a->out_asn}}</td>
                            <td>{{$a->out_name}}</td>
                            <td>{{$a->out_policy_general}}</td>
                          </tr>
                        @endforeach
                        </tbody>
                      </table>

                    </div>
                    <!-- /.card-body -->
                  </div>
                  {{ $asn->links() }}
                @if($org_a && $org_b)

                    <div class="row">
                    <div class="col-12">
                            <h3>{{$org_a}} X {{$org_b}}</h3>
                      <div class="post">
                          <div class="user-block">
                              <h4>Interseção</h4><br>
                              <!-- /.user-block -->
                        <ol class="text-sm" >
                            @foreach($intersection as $el)
                            <li>
                                <b> {{print_r($el->intersecao)}} </b>
                            </li>
                            @endforeach
                        </ol>
                    </div>

                    <p>
                      Objetos Compartilhados {{count($intersection)}}
                    </p>
                </div>


                <div class="post clearfix">
                    <div class="user-block">

                            <h4>União</h4>

                        </div>
                        <!-- /.user-block -->
                        <ol class="text-sm" >
                            @foreach($union as $el)
                            <li>
                                <b> {{print_r($el->uniao)}} </b>
                            </li>
                            @endforeach
                        </ol>
                        <p>
                            Total de Objetos {{count($union)}}
                        </p>
                    </div>

                      <div class="post">
                          <div class="user-block">
                              <h4>Exclusivo {{$org_a}}</h4>
                            </div>
                        <!-- /.user-block -->
                        <ol class="text-sm" >
                            @foreach($only_a as $el)
                            <li>
                                <b> {{print_r($el->diferenca)}} </b>
                            </li>
                            @endforeach
                        </ol>

                        <p>
                            Total de Objetos {{count($only_a)}}
                        </p>
                    </div>

                    <div class="post">
                        <div class="user-block">
                            <h4>Exclusivo {{$org_b}}</h4>
                          </div>
                      <!-- /.user-block -->
                      <ol class="text-sm" >
                        @foreach($only_b as $el)
                        <li>
                            <b> {{print_r($el->diferenca)}} </b>
                        </li>
                        @endforeach
                    </ol>

                    <p>
                        Total de Objetos {{count($only_b)}}
                    </p>
                  </div>



                </div>
            </div>
            @endif
        </div>
              <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
                  <h3 class="text-primary"><i class="fas fa-cogs"></i> Instruções</h3>
                  <p class="text-muted">Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua butcher retro keffiyeh dreamcatcher synth. Cosby sweater eu banh mi, qui irure terr.</p>
                  <form >
                      <div class="form-group">
                          <input class="form-control" name="asn_a" placeholder="Informe um ASN">
                      </div>
                      <div class="form-group">
                          <input class="form-control" name="asn_b" placeholder="Informe um ASN">
                      </div>
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.card-body -->
        </div>
        <!-- /.card -->


@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    @stop

    @section('js')
    <script> console.log('Hi!'); </script>
    @stop
