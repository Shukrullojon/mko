@extends('layouts.admin')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="card-title">
                        <h1>@lang('cruds.report.report')</h1>
                    </h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('global.home')</a></li>
                        <li class="breadcrumb-item active">@lang('cruds.report.report')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="container-fluid">
                    <!-- /.card -->
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home1" data-toggle="pill"
                                       href="#home" role="tab" aria-controls="custom-content-below-home"
                                       aria-selected="true">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile1" data-toggle="pill" href="#profile" role="tab"
                                       aria-controls="custom-content-above-transaction_report"
                                       aria-selected="false">@lang('cruds.report.transaction_report')</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="home">
                                <div class="tab-pane fade show active home" id="home" role="tabpanel"
                                     aria-labelledby="custom-content-below-home-tab">
                                    <table class="table table-bordered table-striped dataTable dtr-inline">
                                        <thead>
                                        <tr>
                                            <th>@lang('cruds.report.posting_date')</th>
                                            <th>@lang('cruds.report.operation_day_dates')</th>
                                            <th>@lang('cruds.report.transaction_number')</th>
                                            <th>@lang('cruds.report.sender_name')/<br>@lang('cruds.report.recipient')
                                                /<br>@lang('cruds.report.purpose_text')</th>
                                            <th>@lang('cruds.report.debit')</th>
                                            <th>@lang('cruds.report.credit')</th>
                                            <th>@lang('global.action')</th>
                                        </tr>

                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade profile" id="profile" role="tabpanel"
                                 aria-labelledby="custom-content-above-transaction_report-tab">
                                <button class="btn btn-sm btn-success"><i class="fa fa-file-excel"></i></button>
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
                                            <td style="min-width: 50px">{{ $payment->date }}</td>
                                            <td>{{ $payment->tr_id }}</td>
                                            <td>{{ number_format($payment->amount/100) }} UZS</td>
                                            <td>{{ $payment->merchant->name }}</td>
                                            <td>{{ $payment->client->first_name.' '.$payment->client->middle_name.' '.$payment->client->last_name }}</td>
                                            <td>{{ $payment->client->id }}</td>
                                            <td>
                                                @foreach($payment->transactions as $trans)
                                                    @if ($trans->percentage == 21)
                                                        {{ number_format($trans->amount/100) }} UZS
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td></td>
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
                                {{ $payments->links() }}
                            </div>
                            <div class="tab-custom-content">
                                <p class="lead mb-0">Custom Content goes here</p>
                            </div>

                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
@section('scripts')
    <link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
    <script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
    <script>
        // const home1 = document.getElementById("home1");
        // const home = document.getElementById("home");
        // const profile1 = document.getElementById("profile1");
        // const profile = document.getElementById("profile");
        // // console.log(profile1)
        // home1.addEventListener('click', (e) => {
        //     if (home.classList.contains('d-none')) {
        //         home.classList.remove('d-none')
        //     }
        //     profile.classList.add('d-none')
        // });
        // profile1.addEventListener('click', (e) => {
        //     if (profile.classList.contains('d-none')) {
        //         profile.classList.remove('d-none')
        //     }
        //     home.classList.add('d-none')
        // });

        $(document).on('pagebeforeshow', '#home', function () {
        });
        $(document).on('pagebeforeshow', '#profile', function () {
        });

    </script>
@endsection
