@extends('layouts.admin')

@section('content')
    @can('merchant.show')
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>@lang('cruds.merchant.merchant')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('global.home')</a></li>
                            <li class="breadcrumb-item active">@lang('cruds.merchant.merchant')</li>
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
                                    <table id="" class="table table-bordered table-striped dataTable dtr-inline"
                                           role="grid"
                                           aria-describedby="">
                                        <thead>
                                        <tr>
                                            <th>@lang('cruds.merchant.filial')</th>
                                            <td>{{ $merchant->filial }}</td>
                                        </tr>
                                        <tr>
                                            <th>QR</th>
                                            <td>
                                                {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(100)->generate($merchant->key); !!}
                                                <a href="{{ route('downloadQrCode', ['key' => $merchant->key]) }}"
                                                   style="float: right" target="_blank" download
                                                   class="btn btn-success ion-android-download">Download</a>

                                            </td>
                                        </tr>
                                        <tr>
                                            <th>@lang('cruds.merchant.merchant_address')</th>
                                            <td>{{ $merchant->address }}</td>
                                        </tr>

                                        </thead>
                                    </table>
                                    <br>
                                    <table id="" class="table table-bordered  dataTable dtr-inline">
                                        <thead>
                                        <tr>
                                            <th>@lang('cruds.merchant.merchant_period')</th>
                                            <th>@lang('cruds.merchant.merchant_percentage')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($merchant->periods as $period)
                                            <tr>
                                                <td>{{ $period->period }}</td>
                                                <td>{{ $period->percentage }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table id="" class="table table-bordered table-striped dataTable dtr-inline"
                                           role="grid"
                                           aria-describedby="">
                                        <thead>

                                        <tr>
                                            <th>@lang('cruds.account.account_number')</th>
                                            <td>{{ $merchant->account->number ?? "" }}</td>
                                        </tr>

                                        <tr>
                                            <th>@lang('cruds.account.name')</th>
                                            <td>{{ $merchant->account->name ?? "" }}</td>
                                        </tr>

                                        <tr>
                                            <th>@lang('cruds.account.account_inn')</th>
                                            <td>{{ $merchant->account->inn ?? "" }}</td>
                                        </tr>

                                        <tr>
                                            <th>@lang('cruds.account.account_filial')</th>
                                            <td>{{ $merchant->account->filial ?? "" }}</td>
                                        </tr>

                                        </thead>
                                    </table>
                                    <br>
                                    <table id="" class="table table-bordered table-striped dataTable dtr-inline"
                                           role="grid" aria-describedby="">
                                        <thead>

                                        <tr>
                                            <th>@lang('cruds.ucoin')</th>
                                            <td>{{ $merchant->account->card->number ?? "" }}</td>
                                        </tr>

                                        <tr>
                                            <th>@lang('cruds.expire')</th>
                                            <td>{{ $merchant->account->card->expire ?? "" }}</td>
                                        </tr>

                                        <tr>
                                            <th>@lang('cruds.balance')</th>
                                            <td>{{ $merchant->account->card->balance ?? "" }}</td>
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
    @endcan
@endsection
