@extends('layouts.admin')

@section('content')

    @can('payment.show')
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
                                            <th>Client</th>
                                            <td>{{ $payment->client->first_name }} {{ $payment->client->last_name }}</td>
                                        </tr>

                                        <tr>
                                            <th>Merchant</th>
                                            <td>{{ $payment->merchant->name }}</td>
                                        </tr>

                                        <tr>
                                            <th>Period</th>
                                            <td>{{ $payment->period }}</td>
                                        </tr>

                                        <tr>
                                            <th>Percentage</th>
                                            <td>{{ $payment->percentage }}</td>
                                        </tr>

                                        <tr>
                                            <th>Amount</th>
                                            <td>{{ number_format($payment->amount/100) }} UZS</td>
                                        </tr>

                                        <tr>
                                            <th>Date</th>
                                            <td>{{ $payment->date }}</td>
                                        </tr>

                                        <tr>
                                            <th>Status</th>
                                            <td>{{ $payment->status }}</td>
                                        </tr>

                                        <tr>
                                            <th>tr_id</th>
                                            <td>{{ $payment->tr_id }}</td>
                                        </tr>


                                        </thead>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table id="" class="table table-bordered table-striped dataTable dtr-inline"
                                           role="grid"
                                           aria-describedby="">
                                        <thead>
                                        <tr>
                                            <th>Sender</th>
                                            <th>Receiver</th>
                                            <th>Amount</th>
                                            <th>Is_sent</th>
                                        </tr>
                                        @php $sum = 0 @endphp
                                        @foreach($payment->transactions as $transaction)
                                            <tr>
                                                <td>
                                                    {{ $transaction->sender->number }}
                                                    <br>
                                                    <span style='font-size: 9px'> {{ $transaction->sender->owner ?? "" }} </span>
                                                </td>
                                                <td>
                                                    {{ $transaction->receiver->number }}
                                                    <br>
                                                    <span style='font-size: 9px'> @if(isset($transaction->receiver->account->merchant->brand->name) and !empty($transaction->receiver->account->merchant->brand->name)){{ "(".$transaction->receiver->account->merchant->brand->name.")" }} @endif {{ $transaction->receiver->owner ?? "111" }} </span>
                                                </td>
                                                <td>
                                                    {{ number_format($transaction->amount/100) }}
                                                </td>
                                                <td>
                                                    {{ $transaction->is_sent }}
                                                </td>
                                            </tr>
                                            @php $sum += $transaction->amount @endphp
                                        @endforeach
                                        <tr>
                                            <td>Итого</td>
                                            <td></td>
                                            <td>{{ number_format($sum/100) }}</td>
                                            <td></td>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endcan

@endsection
