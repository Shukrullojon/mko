<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
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
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
