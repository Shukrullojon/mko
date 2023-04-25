<table class="table table-bordered table-striped dataTable dtr-inline">
    <thead>
    <tr>
        <th style="font-weight: bold; text-align: center">@lang('cruds.report.posting_date')</th>
        <th style="font-weight: bold; text-align: center">@lang('cruds.report.merchant_name')</th>
        <th style="font-weight: bold; text-align: center">@lang('cruds.report.partner.brand_purpose')</th>
        <th style="font-weight: bold; text-align: center">@lang('cruds.report.partner.payment_sum')<br><sub>(uzs)</sub></th>
        <th style="font-weight: bold; text-align: center">@lang('cruds.report.partner.commission_merchant')<br><sub>(uzs)</sub></th>
        <th style="font-weight: bold; text-align: center">@lang('cruds.report.partner.paid_to_merchant')<br><sub>(uzs)</sub></th>
        <th style="font-weight: bold; text-align: center">@lang('cruds.report.partner.commission_bank')<br><sub>(uzs)</sub></th>
    </tr>
    </thead>
    <tbody>
    @foreach($transactions as $t)
        <tr>
            <td>{{ date('Y-m-d', strtotime($t->date)) }}</td>
            <td>{{ $t->merchant_name }}</td>
            <td>{{ $t->brand_purpose }}</td>
            <td>{{ number_format($t->payment_sum) }}</td>
            <td>{{ number_format($t->commission_merchant) }}</td>
            <td>{{ number_format($t->paid_to_merchant) }}</td>
            <td>{{ number_format($t->commission_bank) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
