@extends('layouts.admin')

@section('content')
    @can('brand.add')
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>@lang('global.add')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('global.home')</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('brandIndex') }}">@lang('cruds.brand.brand_name')</a></li>
                            <li class="breadcrumb-item active">@lang('global.add')</li>
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
                            <h3 class="card-title">@lang('global.add')</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">

                            <form action="{{ route('brandStore') }}" method="post" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group">
                                    <label>@lang('cruds.brand.brand_name')</label>
                                    <label for="*" style="color:red">*</label>
                                    <input type="text" name="brand_name" value="{{ old('brand_name') }}"
                                           class="form-control {{ $errors->has('brand_name') ? "is-invalid":"" }}"
                                           autocomplete="off" required>
                                    @if($errors->has('brand_name'))
                                        <span class="error invalid-feedback">{{ $errors->first('brand_name') }}</span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label>@lang('cruds.brand.logo')</label>
                                    <label for="*" style="color:red">*</label>
                                    <input type="file" name="logo" value="{{ old('logo') }}"
                                           class="form-control {{ $errors->has('logo') ? "is-invalid":"" }}"
                                           autocomplete="off" accept="image/*" required>
                                    @if($errors->has('logo'))
                                        <span class="error invalid-feedback">{{ $errors->first('logo') }}</span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label>@lang('cruds.brand.status')</label>
                                    <label for="*" style="color:red">*</label>
                                    <select name="status" id="" class="form-control">
                                        <option value="1">@lang('cruds.status.1')</option>
                                        <option value="0">@lang('cruds.status.0')</option>
                                    </select>
                                    @if($errors->has('status'))
                                        <span class="error invalid-feedback">{{ $errors->first('status') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>@lang('cruds.brand.is_unired')</label>
                                    <label for="*" style="color:red">*</label>
                                    <select name="is_unired" id="" class="form-control" required>
                                        <option value="1">@lang('cruds.status.1')</option>
                                        <option value="0">@lang('cruds.status.0')</option>
                                    </select>
                                    @if($errors->has('is_unired'))
                                        <span class="error invalid-feedback">{{ $errors->first('is_unired') }}</span>
                                    @endif
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
