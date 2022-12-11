@extends('layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('cruds.merchant.merchants')</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('global.home')</a></li>
                        <li class="breadcrumb-item active">@lang('cruds.merchant.merchants')</li>
                        <li class="breadcrumb-item active">@lang('global.show')</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">@lang('global.show')</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table id="" class="table table-bordered table-striped dataTable dtr-inline" role="grid"
                                       aria-describedby="">
                                    <thead>


                                    <tr>
                                        <th>Ид</th>
                                        <td>{{ $merchant->id }}</td>
                                    </tr>
                                    <tr>
                                        <th>@lang('cruds.merchant.name')</th>
                                        <td>{{ $merchant->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>@lang('cruds.merchant.filial')</th>
                                        <td>{{ $merchant->filial }}</td>
                                    </tr>
                                    <tr>
                                        <th>@lang('cruds.merchant.key')</th>
                                        <td>
                                            {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(100)->generate($merchant->key); !!}
                                            <a href="{{ route('downloadSvg', ['key' => $merchant->key]) }}"
                                               style="float: right" target="_blank" download class="btn btn-success ion-android-download">Download</a>

                                        </td>
                                    </tr>
                                    <tr>
                                        <th>@lang('cruds.merchant.address')</th>
                                        <td>{{ $merchant->address }}</td>
                                    </tr>

                                    </thead>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table id="" class="table table-bordered table-striped dataTable dtr-inline" role="grid"
                                       aria-describedby="">
                                    <thead>
                                    <tr>
                                        <th>@lang('cruds.merchant.uzcard_merchant_id')</th>
                                        <td>{{ $merchant->uzcard_merchant_id }}</td>
                                    </tr>
                                    <tr>
                                        <th>@lang('cruds.merchant.uzcard_terminal_id')</th>
                                        <td>{{ $merchant->uzcard_terminal_id }}</td>
                                    </tr>
                                    <tr>
                                        <th>@lang('cruds.merchant.humo_merchant_id')</th>
                                        <td>{{ $merchant->humo_merchant_id }}</td>
                                    </tr>
                                    <tr>
                                        <th>@lang('cruds.merchant.humo_terminal_id')</th>
                                        <td>{{ $merchant->humo_terminal_id }}</td>
                                    </tr>
                                    <tr>
                                        <th>@lang('cruds.merchant.is_register_uzcard')</th>
                                        <td>{{ $merchant->is_register_uzcard }}</td>
                                    </tr>
                                    <tr>
                                        <th>@lang('cruds.merchant.is_register_humo')</th>
                                        <td>{{ $merchant->is_register_humo }}</td>
                                    </tr>
                                    <tr>
                                        <th>@lang('cruds.merchant.account_id')</th>
                                        <td>{{ $merchant->account_id }}</td>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>

                        <div>
                            <a href="{{ route('merchantIndex') }}" type="button" class="btn btn-danger"> Back</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
