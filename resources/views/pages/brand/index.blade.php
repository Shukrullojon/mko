@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('cruds.brand.brands')</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('global.home')</a></li>
                        <li class="breadcrumb-item active">@lang('cruds.brand.brands')</li>
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
                        <h3 class="card-title">@lang('cruds.brand.brands')</h3>
                        <div class="btn-group" style="float: right">
                            @can('brand.add')
                                <a href="{{ route('brandAdd') }}" class="btn btn-success btn-sm float-right">
                                    <span class="fas fa-plus-circle"></span>
                                    @lang('global.add')
                                </a>
                            @endcan

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
                                <th width="80px">@lang('cruds.brand.status')</th>
                                <th>@lang('cruds.brand.logo')</th>
                                <th class="text-center">действие</th>
                            </tr>
                            <tr class="text-center">
                                <form action="">

                                    <th>
                                        <input value="{{ request()->brand_name }}" type="text"
                                               placeholder="@lang('cruds.brand.brand_name')" class="clear-class form-control"
                                               name="brand_name">
                                    </th>
                                    <th>
{{--                                        <input value="{{ request()->status }}" type="text"--}}
{{--                                               placeholder="@lang('cruds.brand.status')"--}}
{{--                                               class="clear-class form-control" name="status">--}}
                                    </th>
                                    <th>
                                    </th>
                                    <th>

                                        <button name="accountSearch" class="btn btn-default" type="submit">
                                            <span class="fa fa-search"></span>
                                        </button>
                                        <a href="{{ route("brandIndex") }}" class="btn btn-danger">
                                            <span class="fa fa-reply"></span>
                                        </a>
                                    </th>
                                </form>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($brands as $brand)
                                <tr>

                                    <td>{{ $brand->name }}</td>
                                    <td class="text-center">{{ status($brand->status) }}</td>
                                    <td class="text-center">
{{--                                        @dd(public_path('images/'.$brand->logo_name))--}}
                                        @if(file_exists(public_path('images/'.$brand->logo_name)))
                                            <img src="{{ $brand->logo }}" alt="" style="width: 50px; height: 50px" >

                                        @endif

                                    </td>
                                    <td class="text-center">
                                        <form action="" method="post">
                                            @csrf
                                            <div class="btn-group ">
                                                <a href="{{ route('brandShow',$brand->id) }}"
                                                   class="btn btn-info btn-sm">
                                                    <span class="fa fa-eye"></span>
                                                </a>
                                                @can('brand.edit')
                                                    <a href="{{ route('brandEdit',$brand->id) }}"
                                                       class="btn btn-primary btn-sm"
                                                       style="margin-left: 5px; margin-right: 5px">
                                                        <span class="fa fa-edit"></span>
                                                    </a>
                                                @endcan
{{--                                                @can('brand.delete')--}}
{{--                                                    <input name="_method" type="hidden" value="DELETE">--}}
{{--                                                    <a href="{{ route('brandDestroy', $brand->id) }}" type="button" class="btn btn-danger btn-sm" onclick="if (confirm('Вы уверены?')) { this.form.submit() } "> @lang('global.delete')</a>--}}
{{--                                                @endcan--}}

                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <br>
                        {{ $brands->appends(
                            request()->except('name'),
                            request()->except('logo'),
                            request()->except('status'),
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
