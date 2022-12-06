@extends('layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('pages.brand.title')</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('global.home')</a></li>
                        <li class="breadcrumb-item active">@lang('cruds.brand.brands')</li>
                        <li class="breadcrumb-item active">@lang('global.edit')</li>
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
                        <h3 class="card-title">@lang('global.edit')</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <form action="{{ route('brandUpdate', $brand->id) }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label>@lang('cruds.brand.name')</label>
                                <input type="text" name="name" class="form-control {{ $errors->has('name') ? "is-invalid":"" }}" value="{{ old('name',$brand->name) }}" required>
                                @if($errors->has('name') || 1)
                                    <span class="error invalid-feedback">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>@lang('cruds.brand.logo')</label>
                                <input type="text" name="logo" class="form-control {{ $errors->has('logo') ? "is-invalid":"" }}" value="{{ old('logo',$brand->logo) }}" required>
                                @if($errors->has('logo') || 1)
                                    <span class="error invalid-feedback">{{ $errors->first('logo') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>@lang('cruds.brand.status')</label>
                                <input type="text" name="status" class="form-control {{ $errors->has('status') ? "is-invalid":"" }}" value="{{ old('status',$brand->status) }}" required>
                                @if($errors->has('status') || 1)
                                    <span class="error invalid-feedback">{{ $errors->first('status') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>@lang('cruds.brand.brands')</label>
                                <input type="text" name="is_unired" class="form-control {{ $errors->has('is_unired') ? "is-invalid":"" }}" value="{{ old('is_unired',$brand->is_unired) }}" required>
                                @if($errors->has('is_unired') || 1)
                                    <span class="error invalid-feedback">{{ $errors->first('is_unired') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-success float-right">@lang('global.save')</button>
                                <a href="{{ route('brandIndex') }}" class="btn btn-default float-left">@lang('global.cancel')</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
