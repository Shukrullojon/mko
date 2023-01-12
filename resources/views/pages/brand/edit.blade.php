@extends('layouts.admin')

@section('content')
    @can('brand.edit')
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

                            <form action="{{ route('brandUpdate', $brand->id) }}" method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('cruds.brand.brand_name')</label>
                                            <label for="*" style="color:red">*</label>
                                            <input type="text" name="brand_name"
                                                   class="form-control {{ $errors->has('brand_name') ? "is-invalid":"" }}"
                                                   value="{{ old('brand_name',$brand->name) }}" required>
                                            @if($errors->has('brand_name') || 1)
                                                <span
                                                    class="error invalid-feedback">{{ $errors->first('brand_name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('cruds.brand.status')</label>
                                            <label for="*" style="color:red">*</label>
                                            <select name="status" id="" class="form-control">
                                                <option value="1"
                                                        @if($brand->status) selected @endif>@lang('cruds.status.1')</option>
                                                <option value="0"
                                                        @if(!$brand->status) selected @endif>@lang('cruds.status.0')</option>
                                            </select>
                                        </div>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>@lang('cruds.brand.logo')</label>
                                            <input type="file" name="logo" value="{{ old('logo') }}"
                                                   class="form-control {{ $errors->has('logo') ? "is-invalid":"" }}"
                                                   accept="image/*">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <img src="{{ $brand->logo }}" id="img" alt=""
                                             style="width: 60px; max-height: 60px" class="ml-5">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('cruds.brand.is_unired')</label>
                                            <label for="*" style="color:red">*</label>
                                            <select name="is_unired" id="" class="form-control">
                                                <option value="1"
                                                        @if($brand->is_unired) selected @endif>@lang('cruds.status.1')</option>
                                                <option value="0"
                                                        @if(!$brand->is_unired) selected @endif>@lang('cruds.status.0')</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit"
                                            class="btn btn-success float-right">@lang('global.save')</button>
                                    <a href="{{ route('brandIndex') }}"
                                       class="btn btn-default float-left">@lang('global.cancel')</a>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endcan
@endsection
