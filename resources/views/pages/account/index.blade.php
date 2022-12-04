@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('cruds.account.account')</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('global.home')</a></li>
                        <li class="breadcrumb-item active">@lang('cruds.account.account')</li>
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
                        <h3 class="card-title">@lang('cruds.account.account')</h3>
                        <div class="btn-group" style="float: right">
                            <a href="{{ route('accountAdd') }}" class="btn btn-success btn-sm float-right">
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
{{--                                        <form action="/accounts" method="get">--}}
{{--                                            <div class="modal-body">--}}
{{--                                                --}}{{--name--}}
{{--                                                <div class="form-group row align-items-center">--}}
{{--                                                    <div class="col-3">--}}
{{--                                                        <h6>name</h6>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="col-6">--}}
{{--                                                        <input class="form-control form-control-sm" type="text" name="search_name" autocomplete="off" value="{{ old('card_number',request()->card_number??'') }}">--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                                <div class="form-group row align-items-center">--}}
{{--                                                    <div class="col-3">--}}
{{--                                                        <h6>account</h6>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="col-6">--}}
{{--                                                        <input class="form-control form-control-sm" type="text" name="search_account" autocomplete="off" value="{{ old('card_number',request()->card_number??'') }}">--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}

{{--                                            </div>--}}

{{--                                            <div class="modal-footer">--}}
{{--                                                <button type="submit" name="" class="btn btn-primary">Применитъ</button>--}}
{{--                                            </div>--}}
{{--                                        </form>--}}
                                    </div>
                                </div>
                            </div>

                            <a href="{{ route('accountIndex') }}" class="btn btn-secondary btn-sm"><i class="fa fa-redo-alt"></i> @lang('global.clear')</a>

                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <!-- Data table -->
                        <table id="" class="table table-bordered table-striped dataTable dtr-inline" role="grid" aria-describedby="dataTable_info">
                            <thead>
                                <tr>
                                    <th>@lang('cruds.account.number')</th>
                                    <th>@lang('cruds.account.inn')</th>
                                    <th>@lang('cruds.account.name')</th>
                                    <th>@lang('cruds.account.filial')</th>
                                    <th>@lang('cruds.account.card')</th>
                                    <th>@lang('cruds.account.percentage')</th>
                                    <th></th>
                                </tr>
                                <tr class="text-center">
                                    <form action="">
                                        <th>
                                            <input value="{{ request()->number }}" type="text" placeholder="@lang('cruds.account.number')" class="clear-class form-control" name="number">
                                        </th>
                                        <th>
                                            <input value="{{ request()->inn }}" type="text" placeholder="@lang('cruds.account.inn')" class="clear-class form-control" name="inn">
                                        </th>
                                        <th>
                                            <input value="{{ request()->name }}" type="text" placeholder="@lang('cruds.account.name')" class="clear-class form-control" name="name">
                                        </th>
                                        <th>
                                            <input value="{{ request()->filial }}" type="text" placeholder="@lang('cruds.account.filial')" class="clear-class form-control" name="filial">
                                        </th>
                                        <th>

                                        </th>
                                        <th>
                                            <input value="{{ request()->percentage }}" type="number" placeholder="@lang('cruds.account.percentage')" class="clear-class form-control" name="percentage">
                                        </th>
                                        <th>
                                            <button name="accountSearch" class="btn btn-default" type="submit">
                                                <span class="fa fa-search"></span>
                                            </button>
                                            <a href="{{ route("accountIndex") }}" class="btn btn-danger">
                                                <span class="fa fa-reply"></span>
                                            </a>
                                        </th>
                                    </form>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($accounts as $account)
                                <tr>
                                    <td>{{ $account->number }}</td>
                                    <td>{{ $account->inn }}</td>
                                    <td>{{ $account->name }}</td>
                                    <td>{{ $account->filial }}</td>
                                    <td>{{ $account->card->number }}</td>
                                    <td>{{ $account->percentage }}</td>
                                    <td>
                                        <form action="{{ route('accountDestroy',$account->id) }}" method="post">
                                            @csrf
                                            <div class="btn-group ">
                                                <a href="{{ route('accountShow',$account->id) }}" class="btn btn-info btn-sm">
                                                    <span class="fa fa-eye"></span>
                                                </a>
                                                <a href="{{ route('accountEdit',$account->id) }}" class="btn btn-primary btn-sm" style="margin-left: 5px; margin-right: 5px">
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
                        {{ $accounts->appends(
                            request()->except('page'),
                            request()->except('number'),
                            request()->except('inn'),
                            request()->except('name'),
                            request()->except('filial'),
                            request()->except('percentage'),
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
