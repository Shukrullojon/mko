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
                        <li class="breadcrumb-item"><a href="{{ route('brandIndex') }}">@lang('global.add')</a></li>
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

                        <form action="{{ route('brandStore') }}" method="post">
                            @csrf

                            <div class="form-group">
                                <label>@lang('cruds.brand.name')</label>
                                <input type="text" name="name" value="{{ old('name') }}"
                                       class="form-control {{ $errors->has('name') ? "is-invalid":"" }}"
                                       autocomplete="off" required>
                                @if($errors->has('name'))
                                    <span class="error invalid-feedback">{{ $errors->first('name') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>@lang('cruds.brand.logo')</label>
                                <input type="file" name="logo" value="{{ old('logo') }}"
                                       class="form-control {{ $errors->has('logo') ? "is-invalid":"" }}"
                                       autocomplete="off" required>
                                @if($errors->has('logo'))
                                    <span class="error invalid-feedback">{{ $errors->first('logo') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>@lang('cruds.brand.status')</label>
                                <input type="text" name="status" value="{{ old('status') }}"
                                       class="form-control {{ $errors->has('status') ? "is-invalid":"" }}"
                                       autocomplete="off" required>
                                @if($errors->has('status'))
                                    <span class="error invalid-feedback">{{ $errors->first('status') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>@lang('cruds.brand.is_unired')</label>
                                <select name="is_unired" id="" class="form-control">
                                    <option value="0">True</option>
                                    <option value="1">False</option>
                                </select>
                                @if($errors->has('is_unired'))
                                    <span class="error invalid-feedback">{{ $errors->first('is_unired') }}</span>
                                @endif
                            </div>


                            <div class="form-group">
                                <button type="submit" class="btn btn-success float-right">@lang('global.save')</button>
                                <a href="{{ route('brandIndex') }}"
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
