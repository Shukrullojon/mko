<table class="table table-bordered table-striped dataTable dtr-inline">
    <thead>
    <tr>
        <th style="font-weight: bold; text-align: center">@lang('cruds.report.posting_date')</th>
        <th style="font-weight: bold; text-align: center">@lang('cruds.report.operation_day_dates')</th>
        <th style="font-weight: bold; text-align: center">@lang('cruds.report.transaction_number')</th>
        <th style="font-weight: bold; text-align: center">@lang('cruds.report.sender_name')</th>
        <th style="font-weight: bold; text-align: center">@lang('cruds.report.recipient')</th>
        <th style="font-weight: bold; text-align: center">@lang('cruds.report.purpose_text')</th>
        <th style="font-weight: bold; text-align: center">@lang('cruds.report.debit')<br><sub>(uzs)</sub></th>
        <th style="font-weight: bold; text-align: center">@lang('cruds.report.credit')<br><sub>(uzs)</sub></th>
        <th style="font-weight: bold; text-align: center">@lang('cruds.report.comission_itunisoft')<br><sub>(uzs)</sub></th>

    </tr>
    </thead>
    <tbody>
    @foreach($uc_transactions as $uc_transaction)
        <tr>
            <td style="min-width: 50px">{{ $uc_transaction->date }}</td>
            <td style="min-width: 50px">{{ $uc_transaction->date }}</td>
            <td>{{ $uc_transaction->numberTrans }}</td>
            <td>{{ $uc_transaction->sender_name }}</td>
            <td>{{ $uc_transaction->recipient }}</td>
            <td>{{ $uc_transaction->purpose_text }}</td>
            <td>{{ ($uc_transaction->debet != 0) ? number_format($uc_transaction->debet/100) : '' }}</td>
            <td>{{ ($uc_transaction->credit != 0) ? number_format($uc_transaction->credit/100) : '' }}</td>
            <td>{{ ($uc_transaction->debet != 0) ? number_format($uc_transaction->debet*0.02/100) : '' }}</td>
            <td></td>
            <td></td>
        </tr>
    @endforeach
    </tbody>
</table>
