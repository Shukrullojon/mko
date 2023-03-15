@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('cruds.payment.payment')</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('global.home')</a></li>
                        <li class="breadcrumb-item active">@lang('cruds.payment.payment')</li>
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
                        <h3 class="card-title">@lang('cruds.payment.payment')</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <!-- Data table -->
                        <table id="" class="table table-bordered table-striped dataTable dtr-inline" role="grid"
                               aria-describedby="dataTable_info">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Client</th>
                                <th>Merchant</th>
                                <th>Period</th>
                                <th>Percentage</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th></th>
                            </tr>

                            </thead>
                            <tbody>
                            @foreach($payments as $payment)
                                <tr>
                                    <td>{{ $payment->name }}</td>
                                    <td>
                                        @if($payment->client)
                                            <a target="_blank"
                                               href="{{ route("clientShow",$payment->client->id ) }}">{{ $payment->client->last_name }} {{ $payment->client->first_name }}</a>
                                            <br>
                                            <span style='font-size: 12px'>{{ $payment->client->card->number }}</span>
                                        @endif
                                    </td>

                                    <td>
                                        <a target="_blank"
                                           href="{{ route("merchantShow",$payment->merchant_id) }}">{{ $payment->merchant->filial ?? "" }}</a>
                                    </td>
                                    <td>{{ $payment->period }}</td>
                                    <td>{{ $payment->percentage }}</td>
                                    <td>{{ $payment->date }}</td>
                                    <td>{{ number_format($payment->amount/100) }} UZS</td>
                                    <td>{{ $payment->status }}</td>
                                    <td>
                                        @can('payment.show')
                                            <a href="{{ route('paymentShow',$payment->id) }}"
                                               class="btn btn-info btn-sm">
                                                <span class="fa fa-eye"></span>
                                            </a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <br>
                        {{ $payments->appends(
                            request()->except('client_id'),
                        )->links() }}
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
