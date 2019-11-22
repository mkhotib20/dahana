@extends('main.template')

@section('content')
        <style>
       
        
        /* Tooltip text */
        .ttt .tooltiptext {
          visibility: hidden;
          width: auto;
          background-color: #dbdbdb;
          color: #000;
          text-align: center;
          padding: 5px;
          border-radius: 6px;
         
          position: absolute;
          z-index: 999;
        }
        
        /* Show the tooltip text when you mouse over the tooltip container */
        .ttt:hover .tooltiptext {
          visibility: visible;
        }
        </style>
        
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">Anggaran Biaya</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
						@if(Auth::user()->role==0 || Auth::user()->role==3)
                            <div class="col-md-6">
                                <div class="card widget-flat">
                                    <div class="card-body container">
                                        {{  Form::open(['route'=>'limit.store', 'method'=>'POST', 'id' => 'bbmForm']) }}    
                                            
                                            <div class="form-group">
                                                <label for="name" class="col-sm-4 control-label">Anggaran </label>
                                                <input type="text" class="form-control rupiah" name="limit" placeholder="Masukan Limit" value="{{$limit}}" >
                                            </div>
                                            <div class="form-group">
                                                    <input type="submit" value="Simpan" class="btn btn-primary btn-block">
                                                </div>

                                        {{  Form::close()  }}
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div>
							@endif
                            <div class="col-md-6">
                                <div class="card widget-flat">
                                    <div class="card-body container">
                                        <form action="{{url('topup')}}" id="formTopUp" method="POST">    
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <div class="form-group">
                                                <label for="name" class="col-sm-4 control-label">Top Up </label>
                                                <input type="text" class="form-control rupiah" name="nominal" placeholder="Masukan Nominal Topup" >
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-success btn-block" ><i class="fe fe-plus"></i>TopUp</button>
                                            </div>
                                        {{  Form::close()  }}
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div>
                            <div class="col-md-8 offset-md-2">
                                <div class="card widget-flat">
                                    <div class="card-body container">
                                        <h3>Riwayat Topup keuangan</h3>
                                        <hr>
                                        <table class="table table-stripped table-hovered">
                                            <thead>
                                              <tr>
                                                  <?php $index = 1;?>
                                                  <th>#</th>
                                                  <th>Nominal</th>
                                                  <th>Tgl Topup</th>
                                              </tr>  
                                            </thead>
                                            <tbody>
                                            @foreach ($topup as $key => $value)
                                                <tr>
                                                    <td>{{$index++}}</td>
                                                    <td class="text-right" > <span class="float-left">Rp </span>{{number_format((-1*$value->nominal), '2', ',', '.')}}</td>
                                                    <td>{{$value->created_at}}</td>
                                                    <td><a class="ttt" style="border-bottom: 1px dashed green;" href="{{url('deltrans/'.$value->id)}} ">Hapus Transaksi <span class="tooltiptext">Transaksi akan dibatalkan</span></a></td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div> 
                                </div> 
                            </div> 
                        </div>                    
                    </div>
@endsection
