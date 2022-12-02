@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Account</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('global.home')</a></li>
                        <li class="breadcrumb-item active">Account</li>
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
                        <h3 class="card-title">Account</h3>
                        {{--                        @can('permission.add')--}}
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

                            <a href="/accounts" class="btn btn-secondary btn-sm"><i class="fa fa-redo-alt"></i> @lang('global.clear')</a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <!-- Data table -->
                        <table id="" class="table table-bordered table-striped dataTable dtr-inline" role="grid" aria-describedby="dataTable_info">
                            <thead>
                            <tr>
                                <th>Type</th>
                                <th>Number</th>
                                <th>Inn</th>
                                <th>Name</th>
                                <th>Filial</th>
                                <th>Persentage</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($accounts as $partner)
                                <tr>
                                    <td>{{ $account->id }}</td>
                                    <td>{{ $account->name }}</td>
                                    <td>{{ $account->account }}</td>
                                    <td>{{ $account->url }}</td>
                                    <td>{{ $account->status }}</td>
                                    <td class="text-center">
                                        @can('partner.delete')
                                            <form action="{{ route('partnerDestroy',$account->id) }}" method="post">
                                                @csrf
                                                <div class="btn-group">
                                                    @can('partner.edit')
                                                        <a href="{{ route('partnerEdit',$account->id) }}" type="button" class="btn btn-info btn-sm"> @lang('global.edit')</a>
                                                    @endcan
                                                    <input name="_method" type="hidden" value="DELETE">
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="if (confirm('Вы уверены?')) {this.form.submit()}"> @lang('global.delete')</button>
                                                </div>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
{{--            {{ $accounts->links('pagination::bootstrap-4') }}--}}
            <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection
