<table class="table table-bordered table-striped dataTable dtr-inline">
    <thead>
    <tr>
        <th style="font-weight: bold; text-align: center">@lang('cruds.report.posting_date')</th>
        <th style="font-weight: bold; text-align: center">@lang('cruds.report.operation_day_dates')</th>
        <th style="font-weight: bold; text-align: center">@lang('cruds.report.transaction_number')</th>
        <th style="font-weight: bold; text-align: center">
            @lang('cruds.report.sender_name')/<br>
            @lang('cruds.report.recipient')/<br>
            @lang('cruds.report.purpose_text')
        </th>
        <th style="font-weight: bold; text-align: center">@lang('cruds.report.debit')</th>
        <th style="font-weight: bold; text-align: center">@lang('cruds.report.credit')</th>

    </tr>
    </thead>
    <tbody>
    @foreach($uc_transactions as $uc_transaction)
        <tr>
            <td style="min-width: 50px">{{ $uc_transaction->date }}</td>
            <td style="min-width: 50px">{{ $uc_transaction->date }}</td>
            <td>{{ $uc_transaction->numberTrans }}</td>
            <td>{{ $uc_transaction->info }}</td>
            <td>{{ $uc_transaction->debet }}</td>
            <td>{{ $uc_transaction->credit }}</td>
            <td></td>
            <td></td>
        </tr>
    @endforeach
    </tbody>
</table>
