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

                        <form action="{{ route('merchantUpdate', $merchant->id) }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>@lang('cruds.merchant.name')</label>
                                        <input type="text" name="name" class="form-control {{ $errors->has('name') ? "is-invalid":"" }}" value="{{ old('name',$merchant->name) }}" required>
                                        @if($errors->has('name') || 1)
                                            <span class="error invalid-feedback">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>@lang('cruds.merchant.key')</label>
                                        <input type="text" name="key" class="form-control {{ $errors->has('key') ? "is-invalid":"" }}" value="{{ old('key',$merchant->key) }}" required>
                                        @if($errors->has('key') || 1)
                                            <span class="error invalid-feedback">{{ $errors->first('key') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>@lang('cruds.merchant.filial')</label>
                                        <input type="text" name="filial" class="form-control {{ $errors->has('filial') ? "is-invalid":"" }}" value="{{ old('filial',$merchant->filial) }}" required>
                                        @if($errors->has('filial') || 1)
                                            <span class="error invalid-feedback">{{ $errors->first('filial') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>@lang('cruds.merchant.address')</label>
                                        <input type="text" name="address" class="form-control {{ $errors->has('address') ? "is-invalid":"" }}" value="{{ old('address',$merchant->address) }}" required>
                                        @if($errors->has('address') || 1)
                                            <span class="error invalid-feedback">{{ $errors->first('address') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>@lang('cruds.merchant.uzcard_merchant_id')</label>
                                        <input type="text" name="uzcard_merchant_id" class="form-control {{ $errors->has('uzcard_merchant_id') ? "is-invalid":"" }}" value="{{ old('uzcard_merchant_id',$merchant->uzcard_merchant_id) }}" required>
                                        @if($errors->has('uzcard_merchant_id') || 1)
                                            <span class="error invalid-feedback">{{ $errors->first('uzcard_merchant_id') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>@lang('cruds.merchant.uzcard_terminal_id')</label>
                                        <input type="text" name="uzcard_terminal_id" class="form-control {{ $errors->has('uzcard_terminal_id') ? "is-invalid":"" }}" value="{{ old('uzcard_terminal_id',$merchant->uzcard_terminal_id) }}" required>
                                        @if($errors->has('uzcard_terminal_id') || 1)
                                            <span class="error invalid-feedback">{{ $errors->first('uzcard_terminal_id') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>@lang('cruds.merchant.humo_merchant_id')</label>
                                        <input type="text" name="humo_merchant_id" class="form-control {{ $errors->has('humo_merchant_id') ? "is-invalid":"" }}" value="{{ old('humo_merchant_id',$merchant->humo_merchant_id) }}" required>
                                        @if($errors->has('humo_merchant_id') || 1)
                                            <span class="error invalid-feedback">{{ $errors->first('humo_merchant_id') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>@lang('cruds.merchant.humo_terminal_id')</label>
                                        <input type="text" name="humo_terminal_id" class="form-control {{ $errors->has('humo_terminal_id') ? "is-invalid":"" }}" value="{{ old('humo_terminal_id',$merchant->humo_terminal_id) }}" required>
                                        @if($errors->has('humo_terminal_id') || 1)
                                            <span class="error invalid-feedback">{{ $errors->first('humo_terminal_id') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>@lang('cruds.merchant.is_register_uzcard')</label>
                                        <input type="text" name="is_register_uzcard" class="form-control {{ $errors->has('is_register_uzcard') ? "is-invalid":"" }}" value="{{ old('is_register_uzcard',$merchant->is_register_uzcard) }}" required>
                                        @if($errors->has('is_register_uzcard') || 1)
                                            <span class="error invalid-feedback">{{ $errors->first('is_register_uzcard') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>@lang('cruds.merchant.is_register_humo')</label>
                                        <input type="text" name="is_register_humo" class="form-control {{ $errors->has('is_register_humo') ? "is-invalid":"" }}" value="{{ old('is_register_humo',$merchant->is_register_humo) }}" required>
                                        @if($errors->has('is_register_humo') || 1)
                                            <span class="error invalid-feedback">{{ $errors->first('is_register_humo') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>@lang('cruds.merchant.account_id')</label>
                                        <input type="text" name="account_id" class="form-control {{ $errors->has('account_id') ? "is-invalid":"" }}" value="{{ old('account_id',$merchant->account_id) }}" required>
                                        @if($errors->has('account_id') || 1)
                                            <span class="error invalid-feedback">{{ $errors->first('account_id') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>@lang('cruds.merchant.brand_id')</label>
                                        <select name="brand_id" id="brand_id" class="form-control brand1" {{ $errors->has('brand_id') ? "is-invalid":"" }}">
                                        @foreach(\App\Models\Pages\Brand::get() as $brand)
                                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                            @endforeach
                                            </select>
                                            @if($errors->has('brand_id'))
                                                <span class="error invalid-feedback">{{ $errors->first('brand_id') }}</span>
                                            @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-success float-right">@lang('global.save')</button>
                                <a href="{{ route('merchantIndex') }}" class="btn btn-default float-left">@lang('global.cancel')</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
