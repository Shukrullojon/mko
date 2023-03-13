@extends('layouts.admin')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('cruds.report.transaction')</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('global.home')</a></li>
                        <li class="breadcrumb-item active">@lang('cruds.report.transaction')</li>
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
                        <h3 class="card-title">@lang('cruds.report.transaction')</h3>
                        <form action="{{ route('reportExport') }}">
                            <button name="export" class="btn btn-success btn-sm float-right"> <i class="fa fa-file-excel"></i> @lang('global.datatables.excel')</btn>
                            <input type="hidden" class="form-control" name="fromDate" value="{{ request()->input('fromDate') }}">
                            <input type="hidden" class="form-control" name="toDate" value="{{ request()->input('toDate') }}">
                        </form>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <!-- Data table -->
                        <table class="table table-bordered table-striped dataTable dtr-inline">
                            <thead>
                            <tr>
                                <th>@lang('cruds.report.date_issue')</th>
                                <th>@lang('cruds.report.transaction_number')</th>
                                <th>@lang('cruds.report.transaction_amount')</th>
                                <th>@lang('cruds.report.merchant_name')</th>
                                <th>@lang('cruds.report.fio')</th>
                                <th>@lang('cruds.report.client_id')</th>
                                <th>@lang('cruds.report.comission_paylater')</th>
                                <th>@lang('cruds.report.vat')</th>
                                <th>@lang('cruds.report.comission_it_unisoft')</th>
                                <th>@lang('global.action')</th>
                            </tr>
                            <tr>
                                <form action="" method="get">
                                    <th colspan="3">
                                        <input type="date" class="form-control" name="fromDate"
                                               value="{{ request()->input('fromDate') }}">
                                    </th>
                                    <th colspan="3">
                                        <input type="date" class="form-control" name="toDate"
                                               value="{{ request()->input('toDate') }}">
                                    </th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th style="white-space: nowrap">
                                        <button name="accountSearch" class="btn btn-default" type="submit">
                                            <span class="fa fa-search"></span>
                                        </button>
                                        <a href="{{ route("reportTransaction") }}" class="btn btn-danger">
                                            <span class="fa fa-reply"></span>
                                        </a>
                                    </th>
                                </form>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($payments as $payment)
                                <tr>
                                    <td style="min-width: 50px">{{ $payment->date }}</td>
                                    <td>{{ $payment->tr_id }}</td>
                                    <td>{{ number_format($payment->amount/100) }} UZS</td>
                                    <td>{{ $payment->merchant->name }}</td>
                                    <td>{{ $payment->client->first_name.' '.$payment->client->middle_name.' '.$payment->client->last_name }}</td>
                                    <td>{{ $payment->client->id }}</td>
                                    <td>
                                        {{ number_format($payment->amount*0.23/100) }} UZS
{{--                                        @foreach($payment->transactions as $trans)--}}
{{--                                            @if ($trans->percentage == 21)--}}
{{--                                                {{ number_format($trans->amount/100) }} UZS--}}
{{--                                            @endif--}}
{{--                                        @endforeach--}}
                                    </td>
                                    <td>{{ number_format($payment->amount*0.23*12/11200) }} UZS</td>
                                    <td>
                                        @foreach($payment->transactions as $trans)
                                            @if ($trans->percentage == 2)
                                                {{ number_format($trans->amount/100) }} UZS
                                            @endif
                                        @endforeach
                                    </td>
                                    <td></td>
                                    {{--                                    <td><a href="{{ route('reportShow', $payment->id) }}" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a></td>--}}
                                </tr>
                            @endforeach
                            </tbody>
                            <br>
                        </table>
                        <br>
                        {{ $payments->links() }}

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
