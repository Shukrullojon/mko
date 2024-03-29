@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('cruds.merchant.merchants')</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('global.home')</a></li>
                        <li class="breadcrumb-item active">@lang('cruds.merchant.merchants')</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">@lang('cruds.merchant.merchants')</h3>
                        <div class="btn-group" style="float: right">
                        @can('merchant.add')
                                <a href="{{ route('merchantAdd') }}" class="btn btn-success btn-sm float-right">
                                    <span class="fas fa-plus-circle"></span>
                                    @lang('global.add')
                                </a>
                            @endcan
                        </div>
                        <div>
                            <form action="{{ route('exportMerchant') }}">
                                <button name="export" class="btn btn-success btn-sm float-right" style="margin-right: 15px"> <i class="fa fa-file-excel"></i> @lang('global.datatables.excel')</button>
                            </form>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <!-- Data table -->
                        <table id="" class="table table-bordered table-striped dataTable dtr-inline" role="grid"
                               aria-describedby="dataTable_info">
                            <thead>
                            <tr>
                                <th>@lang('cruds.brand.brand_name')</th>
                                {{--<th>@lang('cruds.merchant.merchant_name')</th>--}}
                                <th>@lang('cruds.merchant.filial')</th>
                                <th>@lang('cruds.merchant.merchant_address')</th>
                                <th>@lang('cruds.account.account')</th>
                                <th>@lang('cruds.brand.status')</th>
                                <th></th>
                            </tr>
                            <tr class="text-center">
                                <form action="">
                                    <th>
                                        @if(count($brands))
                                            <select name="brand_id" class="form-control" id="brand_id">
                                                <option></option>
                                                @foreach($brands as $brand)
                                                    <option @if(request()->brand_id == $brand->id) selected
                                                            @endif value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                @endforeach
                                            </select>
                                        @endif
                                    </th>
                                    <th>
                                        <input value="{{ request()->filial }}" type="text"
                                               placeholder="@lang('cruds.merchant.filial')"
                                               class="clear-class form-control" name="filial">
                                    </th>
                                    <th>
                                        <input value="{{ request()->merchant_address }}" type="text"
                                               placeholder="@lang('cruds.merchant.merchant_address')"
                                               class="clear-class form-control" name="merchant_address">
                                    </th>
                                    <th>
                                        {{--                                            <input value="{{ request()->account_number }}" type="text" placeholder="@lang('cruds.account.account_number')" class="clear-class form-control" name="account_number">--}}
                                    </th>
                                    <th>
                                        <select name="status" class="form-control">
                                            <option></option>
                                            <option @if(isset(request()->status) and request()->status ==1) selected
                                                    @endif value="1">@lang('cruds.status.1')</option>
                                            <option @if(isset(request()->status) and request()->status ==0) selected
                                                    @endif value="0">@lang('cruds.status.0')</option>
                                        </select>
                                    </th>
                                    <th>

                                        <button name="accountSearch" id="searchSubmit" class="btn btn-default"
                                                type="submit">
                                            <span class="fa fa-search"></span>
                                        </button>
                                        <a href="{{ route("merchantIndex") }}" class="btn btn-danger">
                                            <span class="fa fa-reply"></span>
                                        </a>
                                    </th>

                                </form>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $num = (request()->page) ? request()->page*20+1  : 1;
                            @endphp
                            @foreach($merchants as $merchant)
                                <tr>
                                    <td>{{ $merchant->brand->name ?? ""}}</td>
                                    <td>{{ $merchant->filial }}</td>
                                    <td>{{ $merchant->address }}</td>
                                    <td>{{ $merchant->account->number ?? "" }}</td>
                                    <td>@lang('cruds.status.'.$merchant->status)</td>
                                    <td>
                                        <form action="{{ route('merchantDestroy',$merchant->id) }}" method="post">
                                            @csrf
                                            <div class="btn-group ">
                                                @can('merchant.show')
                                                    <a href="{{ route('merchantShow',$merchant->id) }}"
                                                       class="btn btn-info btn-sm">
                                                        <span class="fa fa-eye"></span>
                                                    </a>
                                                @endcan

                                                @can('merchant.edit')
                                                    <a href="{{ route('merchantEdit',$merchant->id) }}"
                                                       class="btn btn-primary btn-sm"
                                                       style="margin-left: 5px; margin-right: 5px">
                                                        <span class="fa fa-edit"></span>
                                                    </a>
                                                @endcan
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <br>
                        {{ $merchants->appends(
                            request()->except('brand_id'),
                            request()->except('name'),
                            request()->except('account_id'),
                            request()->except('key'),
                        )->links() }}
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection

@section('scripts')
    <script>
        $(document).on("change", "#brand_id", function () {
            $("#searchSubmit").submit();
        })
    </script>
@endsection
