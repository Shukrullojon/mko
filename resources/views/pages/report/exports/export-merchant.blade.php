<table class="table table-bordered table-striped dataTable dtr-inline">
    <thead>
    <tr>
        <th style="font-weight: bold; text-align: center; background-color: #ed969e">@lang('cruds.brand.brand_name')</th>
        <th style="font-weight: bold; text-align: center; background-color: #ed969e">@lang('cruds.merchant.filial')</th>
        <th style="font-weight: bold; text-align: center; background-color: #ed969e">@lang('cruds.merchant.merchant_address')</th>
        <th style="font-weight: bold; text-align: center; background-color: #ed969e">@lang('cruds.account.account')</th>
        <th style="font-weight: bold; text-align: center; background-color: #ed969e">@lang('cruds.brand.status')</th>
    </tr>
    </thead>
    <tbody>
    @foreach($merchants as $m)
        <tr>
            <td>{{ $m->brand->name }}</td>
            <td>{{ $m->filial }}</td>
            <td>{{ $m->address }}</td>
            <td>{{ $m->account->number }}</td>
            <td>{{ $m->status }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
