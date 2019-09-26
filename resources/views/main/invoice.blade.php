@extends('main.template')

@section('content')
<script>
//window.print()
</script>
<div class="container-fluid">
<div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                    <div class="text-right d-print-none">
                                        <a href="javascript:window.print()" class="btn btn-primary waves-effect waves-light"><i class="mdi mdi-printer mr-1"></i> Print</a>
                                    </div>
                                    </div>
                                    <h4 class="page-title">Invoice</h4>
                                </div>
                            </div>
                        </div>     
                        <div class="mt-4 mb-1">
                                    
                                </div>

                        <div class="row mt-3 mb-3">
                            <div class="col-md-12 ">
                                <!-- Logo & title -->
                                <div class="clearfix">
                                    <div class="float-left">
                                        <img src="{{ asset('public/template/') }}/assets/images/logo.png" alt="" height="40">
                                    </div>
                                    <div class="float-right">
                                        <h4 class="m-0 d-print-none">Invoice</h4>
                                    </div>
                                </div>
    
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="pull-left mt-3">
                                            <p><b>Yth, {{$query[0]['per_karyawan']}} </b></p>
                                            <p class="text-muted">Berikut detail biaya untuk perjalanan dinas anda ke kota Subang
                                                <?php 
                                                    for ($i=0; $i < count($kota); $i++) { 
                                                        
                                                        echo ' - ';
                                                        echo $kota[$i];
                                                    }
                                                ?>    
                                            . </p>
                                        </div>
    
                                    </div><!-- end col -->
                                    <div class="col-sm-4 offset-sm-2">
                                        <div class="mt-3 float-right">
                                            <p class="m-b-10"><strong>Tanggal : </strong> <span class="float-right"> &nbsp;&nbsp;&nbsp;{{date('d M Y')}} </span></p>
                                            <p class="m-b-10"><strong>No Invoice. : </strong> <span class="float-right"> &nbsp;&nbsp;{{$no_inv}} </span></p>
                                        </div>
                                    </div><!-- end col -->
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table mt-4 table-centered">
                                                <thead>
                                                <?php $no =1; ?>
                                                <tr><th style="width: 10px">#</th>
                                                    <th>Item</th>
                                                    <th style="width: 150px;"  class="text-right">Total</th>
                                                </tr></thead>
                                                <tbody>
                                                    @foreach ($biaya as $val)
                                                <tr>
                                                    <td> {{$no++}} </td>
                                                    <td>
                                                        <b> <?php echo $val['nama'] ?> </b> <br/>
                                                    </td>
                                                    <td class="text-right"><span class="float-left" > </span><?php echo number_format($val['nominal'], '2', ',', '.'); ?></td>
                                                </tr>

                                                @endforeach
                                                <tr>
                                                    <td> {{$no++}} </td>
                                                    <td>
                                                        <b> Biaya Tambahan : </b> <br/>
                                                    </td>
                                                    <td class="text-right"> </td>
                                                </tr>
                                                @foreach ($biayaTambahan as $val)
                                                <tr>
                                                    <td> </td>
                                                    <td>
                                                        <?php echo $val['nama'] ?> <br/>
                                                    </td>
                                                    <td class="text-right"><span class="float-left" > </span><?php echo number_format($val['nominal'], '2', ',', '.'); ?></td>
                                                </tr>

                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div> <!-- end table-responsive -->
                                    </div> <!-- end col -->
                                </div>
                                <!-- end row -->
    
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="clearfix pt-5">
                                            <!--<h6 class="text-muted">Notes:</h6>

                                            <small class="text-muted">
                                                All accounts are to be paid within 7 days from receipt of
                                                invoice. To be paid by cheque or credit card or direct payment
                                                online. If account is not paid within 7 days the credits details
                                                supplied as confirmation of work undertaken will be charged the
                                                agreed quoted fee noted above.
                                            </small>-->
                                        </div>
                                    </div> <!-- end col -->
                                    <div class="col-sm-6">
                                        <div class="float-right">
                                            <h3>{{'Rp ' . number_format($query[0]['per_biaya'], '2', ',', '.')}}</h3>
                                            <p>{{$terbilang}}</p>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div> <!-- end col -->
                                </div>
                                <!-- end row -->
    
                                
                            </div> <!-- end col -->
                        </div>
                        <!-- end row --> 
                        
                    </div>
@endsection