@extends('layouts.master-backend')

@section('title')
    <title>Data Slider - BLP Official Website 2017</title>
@endsection

@section('content')
    <!-- START PAGE HEADING -->
    <div class="app-heading app-heading-bordered app-heading-page">
        <div class="title">
            <h1>Data Slider</h1>
            <p>Berikut Adalah Halaman untuk manajemen Data Slider.</p>
        </div>               
    </div>
    <div class="app-heading-container app-heading-bordered bottom">
        <ul class="breadcrumb">
            <li><a href="#">Dashboard</a></li>
            <li class="active">Data Slider</li>
        </ul>
    </div>
    <!-- END PAGE HEADING -->

    <!-- START PAGE CONTAINER -->
    <div class="container">
        <div class="block block-condensed">
            <!-- START HEADING -->
            <div class="app-heading app-heading-small">
                <div class="title">
                    <h2>Data Slider</h2>
                </div>
                <div class="heading-elements">
                    <a href="{{ URL::to('/slider/-1') }}" class="btn btn-primary btn-shadowed btn-xs">
                        <span class="fa fa-plus"></span>&nbsp;&nbsp;
                        Tambah Data Slider
                    </a>
                </div>
                              
            </div>
            <!-- END HEADING -->
            
            <div class="block-content">
                    <div class="row" id="loader">
                        <div class="col-lg-12">
                            <center>
                                <div class="app-spinner loading loading-primary" style="float:none !important;"></div>
                            </center>
                        </div>
                    </div>
                <div id="data"></div>
            </div>
        </div>
    </div>
    <style>
    table td
    {
        padding:5px !important;
    }
    </style>
    <!-- END PAGE CONTAINER -->
@endsection

@section('pagescripts') 
    <script type="text/javascript" src="{{ asset('theme/js/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('theme/js/vendor/datatables/dataTables.bootstrap.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            loaddata();
            
            var pesan='{{(session('pesan') ? session('pesan') : '' )}}';
            //var pesan='hi';
            if(pesan!='')
            {
                noty({
                    text: "<strong>Informasi</strong>"+pesan,
                    type: 'information',
                    layout: 'topRight',
                    animation: {
                        open: 'animated bounceIn',
                        close: 'animated fadeOut',                    
                        speed: 400
                    },
                    progressBar:true,
                    timeout:3000
                });
            }
        });
        function loaddata()
        {
            $('#loader').show();
            $('#data').load(APP_URL+'/slider-data/-1',function(){
                $('#loader').hide();
                $('#table-video').dataTable();
                if($(".switch").length > 0){
                    $(".switch").each(function(){
                        $(this).append("<span></span>");
                    });
                }
                
            });
        }
        
        function edit(id)
        {
            location.href=APP_URL+'/slider/'+id;
        }

        function hapus(id)
        {
            $('#modal-primary-header').text('Peringatan');
            $('#modal-primary-body').html('<h2>Yakin ingin Menghapus Data Slider Ini ?</h2>');
            $('div#modal-primary').modal('show');
            $('#ok').click(function(){
                $.ajax({
                    url: APP_URL+'/slider/'+id,
                    type : 'DELETE',
                    dataType: 'json',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    data: {"_token": "{{ csrf_token() }}"}
                }).done(function(data){
                    var txt = "Data Slider Berhasil Di Hapus";
                    noty({
                        text: "<strong>Informasi</strong>"+txt,
                        type: 'information',
                        layout: 'topRight',
                        animation: {
                            open: 'animated bounceIn',
                            close: 'animated fadeOut',                    
                            speed: 400
                        },
                        progressBar:true,
                        timeout:3000
                    });
                    $('div#modal-primary').modal('hide');
                    loaddata();

                }).fail(function(){
                    var txt = " Data Slider Gagal Di Hapus";
                    noty({
                        text: "<strong>Informasi</strong>"+txt,
                        type: 'error',
                        layout: 'topRight',
                        animation: {
                            open: 'animated bounceIn',
                            close: 'animated fadeOut',                    
                            speed: 400
                        },
                        progressBar:true,
                        timeout:3000
                    });
                    $('div#modal-primary').modal('hide');
                });
            });
        }
    </script>
@endsection
