<table class="table table-bordered table-striped dataTable dtr-inline">
    <thead>
    <tr>
        <th class="text-center">@lang('cruds.report.merchant_name')</th>
        <th class="text-center">@lang('cruds.report.partner.brand_purpose')<br><sub>(tiyin)</sub></th>
        <th class="text-center">@lang('cruds.report.partner.commission_merchant')<br><sub>(tiyin)</sub></th>
        <th class="text-center">@lang('cruds.report.partner.paid_to_merchant')<br><sub>(tiyin)</sub></th>
        <th class="text-center">@lang('cruds.report.partner.commission_bank')<br><sub>(tiyin)</sub></th>
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
        </tr>
    @endforeach
    </tbody>
</table>
