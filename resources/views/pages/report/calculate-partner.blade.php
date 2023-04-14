@extends('layouts.admin')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('cruds.report.partner.calculate_partner')</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('global.home')</a></li>
                        <li class="breadcrumb-item active">@lang('cruds.report.partner.calculate_partner')</li>
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
                        <h3 class="card-title">@lang('cruds.report.partner.calculate_partner')</h3>
                        <form action="{{ route('export.calculate-partner') }}">
                            <button name="export" id="excel" class="btn btn-success btn-sm float-right"> <i class="fa fa-file-excel"></i> @lang('global.datatables.excel')</button>
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
                                <th class="text-center">@lang('cruds.report.merchant_name')</th>
                                <th class="text-center">@lang('cruds.report.partner.brand_purpose')</th>
                                <th class="text-center">@lang('cruds.report.partner.payment_sum')<br><sub>(tiyin)</sub></th>
                                <th class="text-center">@lang('cruds.report.partner.commission_merchant')<br><sub>(tiyin)</sub></th>
                                <th class="text-center">@lang('cruds.report.partner.paid_to_merchant')<br><sub>(tiyin)</sub></th>
                                <th class="text-center">@lang('cruds.report.partner.commission_bank')<br><sub>(tiyin)</sub></th>
                                <th class="text-center">@lang('global.action')</th>
                            </tr>
                            <tr>
                                <form action="" method="get">
                                    <th>
                                        <input type="date" class="form-control" name="fromDate" id="fromDate"
                                               value="{{ request()->input('fromDate') }}">
                                    </th>
                                    <th>
                                        <input type="date" class="form-control" name="toDate" id="toDate"
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
                                        <a href="{{ route("report.calculate-partner") }}" class="btn btn-danger">
                                            <span class="fa fa-reply"></span>
                                        </a>
                                    </th>
                                </form>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($transactions as $t)
                                <tr>
                                    <td>{{ $t->merchant_name }}</td>
                                    <td>{{ $t->brand_purpose }}</td>
                                    <td>{{ number_format($t->payment_sum/100, 2, '.', '') }}</td>
                                    <td>{{ number_format($t->commission_merchant/100, 2, '.', '') }}</td>
                                    <td>{{ number_format($t->paid_to_merchant/100, 2, '.', '') }}</td>
                                    <td>{{ number_format($t->commission_bank/100, 2, '.', '') }}</td>
                                    <td></td>
                                </tr>
                            @endforeach
                            </tbody>
                            <br>
                        </table>
                        <br>
{{--                        {{ $transactions->links() }}--}}

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

