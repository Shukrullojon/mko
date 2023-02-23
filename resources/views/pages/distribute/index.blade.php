@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('cruds.report.report')</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('global.home')</a></li>
                        <li class="breadcrumb-item active">@lang('cruds.report.report')</li>
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
                        <h3 class="card-title">@lang('cruds.report.report')</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <!-- Data table -->
                        <table id="" class="table table-bordered table-striped dataTable dtr-inline" role="grid"
                               aria-describedby="dataTable_info">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>MKO <span style="font-family: Constantia">(21%)</span></th>
                                <th>IT GR <span style="font-family: Constantia">(2%)</span></th>
                                <th>Merchant <span style="font-family: Constantia">(77%)</span></th>
                                <th>Total <span style="font-family: Constantia">(100%)</span></th>
                                <th>@lang('global.action')</th>
                            </tr>
                            <tr class="text-center">
                                <form action="">
                                    <th>
                                        <input value="{{ request()->date }}" type="date"
                                               class="clear-class form-control" name="date">
                                    </th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>

                                        <button name="accountSearch" id="searchSubmit" class="btn btn-default"
                                                type="submit">
                                            <span class="fa fa-search"></span>
                                        </button>
                                        <a href="{{ route("reportIndex") }}" class="btn btn-danger">
                                            <span class="fa fa-reply"></span>
                                        </a>
                                    </th>

                                </form>
                            </tr>

                            </thead>
                            <tbody>
                            @foreach($payments as $payment)
                                <tr>
                                    <td>{{ $payment->date }}</td>
                                    <td>
                                        @foreach($transactions as $transaction)
                                            @if($payment->id == $transaction->payment_id and $transaction->percentage == 21)
                                                {{ number_format($transaction->amount/100) }} UZS
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach($transactions as $transaction)
                                            @if($payment->id == $transaction->payment_id and $transaction->percentage == 2)
                                                {{ number_format($transaction->amount/100) }} UZS
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach($transactions as $transaction)
                                            @if($payment->id == $transaction->payment_id and $transaction->percentage == 77)
                                                {{ number_format($transaction->amount/100) }} UZS<br>
                                                <a target="_blank"
                                                   href="{{ route("merchantShow",$payment->merchant_id) }}" style="font-size: 12px">{{ $payment->merchant->name }}
                                                </a>
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        {{ number_format($payment->amount/100) }} UZS
                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <br>
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
