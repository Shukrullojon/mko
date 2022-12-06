@extends('layouts.admin')

@section('content')

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
                        <li class="breadcrumb-item"><a href="{{ route('merchantIndex') }}">@lang('global.add')</a></li>
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

                        <form action="{{ route('merchantStore') }}" method="post">
                            @csrf

                            <div class="form-group">
                                <label>@lang('cruds.merchant.brand_id')</label>
                                <select name="brand_id" id="brand_id"
                                        class="form-control brand1" {{ $errors->has('brand_id') ? "is-invalid":"" }}">
                                @foreach(\App\Models\Pages\Brand::get() as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endforeach
                                    </select>
                                    {{--                                <input type="brand_id" name="brand_id" value="{{ old('brand_id') }}" class="form-control {{ $errors->has('brand_id') ? "is-invalid":"" }}" autocomplete="off" required>--}}
                                    @if($errors->has('brand_id'))
                                        <span class="error invalid-feedback">{{ $errors->first('brand_id') }}</span>
                                    @endif
                            </div>

                            <div class="form-group">
                                <label>@lang('cruds.merchant.name')</label>
                                <input type="text" name="name" value="{{ old('name') }}"
                                       class="form-control {{ $errors->has('name') ? "is-invalid":"" }}"
                                       autocomplete="off" required>
                                @if($errors->has('name'))
                                    <span class="error invalid-feedback">{{ $errors->first('name') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>@lang('cruds.merchant.account_id')</label>
                                <input type="text" name="account_id" value="{{ old('account_id') }}"
                                       class="form-control {{ $errors->has('account_id') ? "is-invalid":"" }}"
                                       autocomplete="off" required>
                                @if($errors->has('account_id'))
                                    <span class="error invalid-feedback">{{ $errors->first('account_id') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>@lang('cruds.merchant.key')</label>
                                <input type="text" name="key" value="{{ old('key') }}"
                                       class="form-control {{ $errors->has('key') ? "is-invalid":"" }}"
                                       autocomplete="off" required>
                                @if($errors->has('key'))
                                    <span class="error invalid-feedback">{{ $errors->first('key') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-success float-right">@lang('global.save')</button>
                                <a href="{{ route('merchantIndex') }}"
                                   class="btn btn-default float-left">@lang('global.cancel')</a>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            $("select.brand1").change(function () {
                var brandId = $(this).children("option:selected").val();
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: 'POST',
                    data: {brandId: brandId},
                    url: '{{ route('getBrand') }}',
                    success: function (data) {
                        if (data) {
                            alert(data)
                        } else {
                            alert('error')
                        }
                    }
                });
            });
        });
    </script>
@endsection
