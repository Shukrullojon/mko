<table class="table table-bordered table-striped dataTable dtr-inline">
    <thead>
    <tr>
        <th style="font-weight: bold; text-align: center">@lang('cruds.report.date_issue')</th>
        <th style="font-weight: bold; text-align: center">@lang('cruds.report.transaction_number')</th>
        <th style="font-weight: bold; text-align: center">@lang('cruds.report.transaction_amount')<br> (tiyin)</th>
        <th style="font-weight: bold; text-align: center">@lang('cruds.report.merchant_name')</th>
        <th style="font-weight: bold; text-align: center">@lang('cruds.report.fio')</th>
        <th style="font-weight: bold; text-align: center">@lang('cruds.report.client_id')</th>
        <th style="font-weight: bold; text-align: center">@lang('cruds.report.comission_paylater')<br> (tiyin)</th>
        <th style="font-weight: bold; text-align: center">@lang('cruds.report.paylater_vat')<br> (tiyin)</th>
        <th style="font-weight: bold; text-align: center">@lang('cruds.report.comission_itunisoft')<br> (tiyin)</th>
        <th style="font-weight: bold; text-align: center">@lang('cruds.report.itunisoft_vat')<br> (tiyin)</th>
    </tr>
    </thead>
    <tbody>
    @foreach($payments as $payment)
        <tr>
            <td style="min-width: 90px">{{ $payment->date }}</td>
            <td>{{ $payment->tr_id }}</td>
            <td>{{ number_format($payment->amount/100, 2, '.', '') }}</td>
            <td>{{ $payment->merchant->filial }}</td>
            <td>{{ $payment->client->first_name.' '.$payment->client->middle_name.' '.$payment->client->last_name }}</td>
            <td>{{ $payment->client->id }}
            <td>{{ number_format($payment->amount*0.23/100, 2, '.', '') }}
            </td>
            <td>{{ number_format($payment->amount*0.23*12/11200, 2, '.', '') }} </td>
            <td>{{ number_format($payment->amount*0.02/100, 2, '.', '') }}</td>
            <td>{{ number_format($payment->amount*0.02*12/11200, 2, '.', '') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
