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
    </thead>
    <tbody>
    @foreach($payments as $payment)
        <tr>
            <td style="min-width: 90px">{{ $payment->date }}</td>
            <td>{{ $payment->tr_id }}</td>
            <td>{{ number_format($payment->amount/100) }} UZS</td>
            <td>{{ $payment->merchant->name }}</td>
            <td>{{ $payment->merchant->name }}</td>
            <td>{{ $payment->client->first_name.' '.$payment->client->middle_name.' '.$payment->client->last_name }}</td>
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
        </tr>
    @endforeach
    </tbody>
</table>
