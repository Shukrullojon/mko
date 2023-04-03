@extends('layouts.admin')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('cruds.report.partner_title')</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('global.home')</a></li>
                        <li class="breadcrumb-item active">@lang('cruds.report.partner_title')</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">@lang('cruds.report.partner_title')</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <!-- Data table -->
                        <table class="table table-bordered table-striped dataTable dtr-inline">
                            <thead>
                            <tr>
                                <th class="text-center">@lang('cruds.report.merchant_name')</th>
                                <th class="text-center">@lang('cruds.report.posting_date')</th>
                                <th class="text-center">@lang('cruds.report.fio')</th>
                                <th class="text-center">@lang('cruds.report.transaction_amount')<br><sub>(tiyin)</sub></th>
                                <th class="text-center">@lang('cruds.report.comission_merchant')<br><sub>(tiyin)</sub></th>
                                <th class="text-center">@lang('cruds.report.comission_paylater')<br><sub>(tiyin)</sub></th>
                                <th class="text-center">@lang('cruds.report.comission_itunisoft')<br><sub>(tiyin)</sub></th>
                                <th class="text-center">@lang('global.action')</th>
                            </tr>
                            <tr>
                                <form action="" method="get">
                                    <th>
                                        <select name="merchant" id="" class="form-control">
                                            <option value="" selected disabled></option>
                                            @foreach(\App\Models\Pages\Merchant::all() as $m)
                                                <option value="{{ $m->id }}">{{ $m->name }}</option>
                                            @endforeach
                                        </select>
                                    </th>
                                    <th>
                                        <input type="date" class="form-control" name="fromDate"
                                               value="{{ request()->input('fromDate') }}">
                                    </th>
                                    <th>
                                        <input type="date" class="form-control" name="toDate"
                                               value="{{ request()->input('toDate') }}">
                                    </th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th style="white-space: nowrap">
                                        <button name="accountSearch" class="btn btn-default" type="submit">
                                            <span class="fa fa-search"></span>
                                        </button>
                                        <a href="{{ route("reportPartner") }}" class="btn btn-danger">
                                            <span class="fa fa-reply"></span>
                                        </a>
                                    </th>
                                </form>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($payments as $payment)
                                <tr>
                                    <td>{{ $payment->merchant->name }}</td>
                                    <td style="min-width: 50px">{{ $payment->date }}</td>
                                    <td>{{ $payment->client->first_name. ' '.$payment->client->middle_name. ' '.$payment->client->last_name }}</td>
                                    <td>{{ number_format($payment->amount/100, 2, '.', '') }}</td>
                                    <td>{{ number_format($payment->amount*0.77/100, 2, '.', '') }}</td>
                                    <td>{{ number_format($payment->amount*0.23/100, 2, '.', '') }}</td>
                                    <td>{{ number_format($payment->amount*0.02/100, 2, '.', '') }}</td>
                                    <td></td>
                                </tr>
                            @endforeach
                            </tbody>
                            <br>
                        </table>
                        <br>
                        {{ $payments->appends($_GET)->links() }}

                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection
