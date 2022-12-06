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
                            <a href="{{ route('merchantAdd') }}" class="btn btn-success btn-sm float-right">
                                <span class="fas fa-plus-circle"></span>
                                @lang('global.add')
                            </a>
                            {{--                        @endcan--}}

                            <button name="filter" value="1" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#filter-modal"><i class="fas fa-filter"></i> @lang('global.filter')</button>

                            <div class="modal fade" id="filter-modal" tabindex="-1" role="dialog" aria-labelledby="filters" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">@lang('global.filter')</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <a href="{{ route('merchantIndex') }}" class="btn btn-secondary btn-sm"><i class="fa fa-redo-alt"></i> @lang('global.clear')</a>

                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <!-- Data table -->
                        <table id="" class="table table-bordered table-striped dataTable dtr-inline" role="grid" aria-describedby="dataTable_info">
                            <thead>
                                <tr>
                                    <th>@lang('cruds.merchant.brand_id')</th>
                                    <th>@lang('cruds.merchant.name')</th>
                                    <th>@lang('cruds.merchant.account_id')</th>
                                    <th>@lang('cruds.merchant.key')</th>
                                    <th></th>
                                </tr>
                                <tr class="text-center">
                                    <form action="">
                                        <th>
                                            <input value="{{ request()->brand_id }}" type="text" placeholder="@lang('cruds.merchant.brand_id')" class="clear-class form-control" name="number">
                                        </th>
                                        <th>
                                            <input value="{{ request()->name }}" type="text" placeholder="@lang('cruds.merchant.name')" class="clear-class form-control" name="inn">
                                        </th>
                                        <th>
                                            <input value="{{ request()->account_id }}" type="text" placeholder="@lang('cruds.merchant.account_id')" class="clear-class form-control" name="name">
                                        </th>
                                        <th>
                                            <input value="{{ request()->key }}" type="text" placeholder="@lang('cruds.merchant.key')" class="clear-class form-control" name="filial">
                                        </th>
                                        <th>

                                            <button name="accountSearch" class="btn btn-default" type="submit">
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
                            @foreach($merchants as $merchant)
                                <tr>
                                    <td>{{ $merchant->brand->name }}</td>
                                    <td>{{ $merchant->name }}</td>
                                    <td>{{ $merchant->account->number }}</td>
                                    <td>{{ $merchant->key }}</td>
                                    <td>
                                        <form action="{{ route('accountDestroy',$merchant->id) }}" method="post">
                                            @csrf
                                            <div class="btn-group ">
                                                <a href="{{ route('accountShow',$merchant->id) }}" class="btn btn-info btn-sm">
                                                    <span class="fa fa-eye"></span>
                                                </a>
                                                <a href="{{ route('accountEdit',$merchant->id) }}" class="btn btn-primary btn-sm" style="margin-left: 5px; margin-right: 5px">
                                                    <span class="fa fa-edit"></span>
                                                </a>
                                                <input name="_method" type="hidden" value="DELETE">
                                                <button type="button" class="btn btn-danger btn-sm" onclick="if (confirm('Вы уверены?')) {this.form.submit()}">
                                                    <span class="fa fa-trash"></span>
                                                </button>
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
