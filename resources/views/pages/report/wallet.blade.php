@extends('layouts.admin')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('cruds.report.wallet')</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('global.home')</a></li>
                        <li class="breadcrumb-item active">@lang('cruds.report.wallet')</li>
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
                        <h3 class="card-title">@lang('cruds.report.wallet')</h3>
                        <form action="{{ route('exportWallet') }}">
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
                                <th>@lang('cruds.report.posting_date')</th>
                                <th>@lang('cruds.report.operation_day_dates')</th>
                                <th>@lang('cruds.report.transaction_number')</th>
                                <th>
                                    @lang('cruds.report.sender_name')/<br>
                                    @lang('cruds.report.recipient')/<br>
                                    @lang('cruds.report.purpose_text')/<br>
                                </th>
                                <th>@lang('cruds.report.debit')</th>
                                <th>@lang('cruds.report.credit')</th>
                                <th>@lang('global.action')</th>
                            </tr>
                            <tr>
                                <form action="" method="get">
                                    <th colspan="2">
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
                                    <th style="white-space: nowrap">
                                        <button name="accountSearch" class="btn btn-default" type="submit">
                                            <span class="fa fa-search"></span>
                                        </button>
                                        <a href="{{ route("reportWallet") }}" class="btn btn-danger">
                                            <span class="fa fa-reply"></span>
                                        </a>
                                    </th>
                                </form>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($uc_transactions as $uc_transaction)
                                <tr>
                                    <td style="min-width: 50px">{{ $uc_transaction->date }}</td>
                                    <td style="min-width: 50px">{{ $uc_transaction->date }}</td>
                                    <td>{{ $uc_transaction->numberTrans }}</td>
                                    <td>{{ $uc_transaction->info }}</td>
                                    <td>{{ $uc_transaction->debet ?? 0 }}</td>
                                    <td>{{ $uc_transaction->credit ?? 0 }}</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            @endforeach
                            </tbody>
                            <br>
                        </table>
                        <br>
                        {{ $uc_transactions->appends($_GET)->links() }}

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
