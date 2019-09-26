@extends('layouts.app')

@section('content')
<div class="text-center w-75 m-auto">
                                    <a href="index.html">
                                        <span><img src="assets/images/logo.png" alt="" height="22"></span>
                                    </a>
                                </div>

                                <div class="text-center mt-4">
                                    <img src="assets/images/error.svg" alt="" height="80">
                                    <h4 class="text-uppercase text-danger mt-3">404 Page Not Found</h4>
                                    <p class="text-muted mt-3">Mohon maaf halaman yang anda cari tidak dapat ditemukan. Periksa kembali url yang anda masukkan, atau pastikan anda memiliki hak akses</p>

                                    <a class="btn btn-info btn-block mt-3" href=" {{route('login')}} "><i class="mdi mdi-reply"></i> Kembali ke halaaman awal</a>
                                </div>

@endsection