@extends('main.template')
@section('content')
<div class="container-fluid">
                        
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    
                                    <h4 class="page-title">Dashboard</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title">Akumulasi biaya perjalanan dinas/Anggaran : Rp {{number_format($biaya_total, '0', ',', '.') }} / <small>{{number_format($limit, '0', ',', '.') }}</small> </h4>
                                        <div style=" padding: 0px; margin: 0px" id="grafik"></div>    
                                    </div>
                                </div>
                            </div> 
                            <div class="col-xl-3 col-lg-6">
                                <div class="card widget-flat">
                                    <div class="card-body p-0">
                                        <div class="p-3 pb-0">
                                            <div class="float-right">
                                                <i class="mdi mdi-account text-primary widget-icon"></i>
                                            </div>
                                            <h5 class="text-muted font-weight-normal mt-0"><b>Driver yang tersedia</b></h5>
                                            <h3 class="mt-2">{{$jumlah_dr}} </h3>
                                            <table class="table table-stripped">
                                                <thead>
                                                    <tr>
                                                        <th>Nama Driver</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="driver-crud">
                                                    <?php $no =1; ?>
                                                    @foreach ($driver as $key => $value)
                                                    <tr>
                                                        <td @if($value->dr_stock==1)
                                                        style="font-weight: bold"
                                                        @else    
                                                        style="color: #dbdbdb"
                                                            @endif >
                                                            {{$value->dr_nama}}</td>
                                                        <td>
                                                            @if($value->dr_stock==0)
                                                                <span style="color: red" class="mdi mdi-block-helper"></span>
                                                            @else
                                                            <span style="color: green" class="mdi mdi-check"></span>    
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col-->

                            <div class="col-xl-3 col-lg-6">
                                <div class="card widget-flat">
                                    <div class="card-body p-0">
                                        <div class="p-3 pb-0">
                                            <div class="float-right">
                                                <i class="mdi mdi-car text-warning widget-icon"></i>
                                            </div>
                                            <h5 class="text-muted font-weight-normal mt-0"><b>Kendaraan yang tersedia</b></h5>
                                            <h3 class="mt-2">{{$jumlah_ken}} </h3>
                                            <table class="table table-stripped">
                                                <thead>
                                                    <tr>
                                                        <th>Merk Mobil</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="driver-crud">
                                                    @foreach ($mobil as $key => $value)
                                                    <tr>
                                                        <td @if($value->ken_stock==1)
                                                        style="font-weight: bold"
                                                        @else    
                                                        style="color: #dbdbdb"
                                                            @endif >
                                                            {{$value->ken_merk}}
                                                        <br>
                                                            <small>{{$value->ken_nopol}}</small>
                                                        </td>
                                                        <td>
                                                            @if($value->ken_stock==0)
                                                                <span style="color: red" class="mdi mdi-block-helper"></span>
                                                            @else
                                                            <span style="color: green" class="mdi mdi-check"></span>    
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div>
                                                  
                        </div>
                        <div class="row">
                            
                        </div>
</div>

        <script src="{{ asset('public/') }}/js/highchart.min.js"></script>
        <script>
            var biaya_total, limit_biaya, sisa_biaya
            limit_biaya =  parseInt({{$limit}})
            biaya_total = parseInt({{$biaya_total}}) || 0
            
            sisa_biaya = limit_biaya-biaya_total
            var d = new Date();
            var n = d.getMonth();
            Highcharts.chart('grafik', {
                colors: ['#D2222D', '#238823'],
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: 0,
                    plotShadow: false
                },
                exporting: { enabled: false },
                title: {
                    text: 'Anggaran biaya perjalanan dinas',
                    align: 'center',
                    verticalAlign: 'top',
                    y: 60
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.y}</b>'
                },
                plotOptions: {
                    pie: {
                        dataLabels: {
                            formatter: function () {
                                return Math.round((100 * this.y / this.total)*100)/100 + '%';
                            },
                            enabled: true,
                            distance: -50,
                            style: {
                                fontWeight: 'bold',
                                color: 'white'
                            }
                        },
                        startAngle: -90,
                        endAngle: 90,
                        center: ['50%', '75%'],
                        size: '110%'
                    }
                },
                series: [{
                    type: 'pie',
                    name: 'Anggaran ',
                    innerSize: '50%',
                    data: [
                        ['Anggaran', biaya_total],
                        ['Sisa Anggaran', sisa_biaya]
                    ]
                }]
            });
        </script>
@endsection