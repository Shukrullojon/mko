@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>MKO</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('global.home')</a></li>
                        <li class="breadcrumb-item active">MKO</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-4">

                                    <div class="small-box bg-info ">
                                        <div class="inner">
                                            <h3 class="text-center">Pay Later<sup style="font-size: 20px"></sup></h3>
                                            <p>{{ $mko->balance??'' }}</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-stats-bars"></i>
                                        </div>
                                        <p href="#" class="small-box-footer " style="text-align: right"></p>
                                    </div>
                                </div>
                                <div class="col-md-4">

                                    <div class="small-box bg-success ">
                                        <div class="inner">
                                            <h3 class="text-center">53<sup style="font-size: 20px">%</sup></h3>
                                            <p>Pay Later</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-stats-bars"></i>
                                        </div>
                                        <p href="#" class="small-box-footer " style="text-align: right">More info </p>
                                    </div>
                                </div>
                                <div class="col-md-4">

                                    <div class="small-box bg-danger ">
                                        <div class="inner">
                                            <h3 class="text-center">53<sup style="font-size: 20px">%</sup></h3>
                                            <p>Pay Later</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-stats-bars"></i>
                                        </div>
                                        <p href="#" class="small-box-footer " style="text-align: right">More info </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- card-body -->
                        <div class="card-body">
                            <table class="table table-bordered table-striped dataTable dtr-inline" role="grid" aria-describedby="dataTable_info">
                                <thead>
                                <tr>
                                    <th>header</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>body</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
@endsection
