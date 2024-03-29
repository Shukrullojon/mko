@extends('layouts.admin')

@section('content')
    @can('merchant.add')
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
                                href="{{ route('merchantIndex') }}">@lang('cruds.merchant.merchant')</a></li>
                        <li class="breadcrumb-item active">@lang('global.add')</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">@lang('global.add')</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <form action="{{ route('merchantStore') }}" method="post">
                            @csrf

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>@lang('cruds.brand.brand_name')</label>
                                        <label for="*" style="color:red">*</label>
                                        <select name="brand_id" id="brand_id" class="form-control" {{ $errors->has('brand_id') ? "is-invalid":"" }}">
                                        @foreach($brands as $brand)
                                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                            @endforeach
                                            </select>
                                            @if($errors->has('brand_id'))
                                                <span
                                                        class="error invalid-feedback">{{ $errors->first('brand_id') }}</span>
                                            @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>@lang('cruds.merchant.filial')</label>
                                        <label for="*" style="color:red">*</label>
                                        <input type="text" name="filial" value="{{ old('filial') }}"
                                               class="form-control {{ $errors->has('filial') ? "is-invalid":"" }}"
                                               autocomplete="off" required>
                                        @if($errors->has('filial'))
                                            <span class="error invalid-feedback">{{ $errors->first('filial') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>@lang('cruds.merchant.merchant_address')</label>
                                        <label for="*" style="color:red">*</label>
                                        <input type="text" name="merchant_address" value="{{ old('merchant_address') }}"
                                               class="form-control {{ $errors->has('merchant_address') ? "is-invalid":"" }}"
                                               autocomplete="off" required>
                                        @if($errors->has('merchant_address'))
                                            <span
                                                class="error invalid-feedback">{{ $errors->first('merchant_address') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-3">
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
                                </div>
                            </div>

                            <hr style="background-color: #9f1447; border-width: 2px">

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>@lang('cruds.account.account')</label>
                                        <label for="*" style="color:red">*</label>
                                        <input type="text" name="account_number" id="account_number"
                                               value="{{ old('account_number') }}"
                                               class="form-control {{ $errors->has('account_number') ? "is-invalid":"" }}"
                                               autocomplete="off" required>
                                        @if($errors->has('account_number'))
                                            <span
                                                class="error invalid-feedback">{{ $errors->first('account_number') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>@lang('cruds.account.name')</label>
                                        <label for="*" style="color:red">*</label>
                                        <input type="text" name="account_name"
                                               id="account_name"
                                               value="{{ old('account_name') }}"
                                               class="form-control {{ $errors->has('account_name') ? "is-invalid":"" }}"
                                               autocomplete="off" required>
                                        @if($errors->has('account_name'))
                                            <span
                                                class="error invalid-feedback">{{ $errors->first('account_name') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>@lang('cruds.account.account_inn')</label>
                                        <label for="*" style="color:red">*</label>
                                        <input type="text" name="account_inn"
                                               id="account_inn"
                                               value="{{ old('account_inn') }}"
                                               class="form-control {{ $errors->has('account_inn') ? "is-invalid":"" }}"
                                               autocomplete="off" required>
                                        @if($errors->has('account_inn'))
                                            <span
                                                class="error invalid-feedback">{{ $errors->first('account_inn') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>@lang('cruds.account.account_filial')</label>
                                        <label for="*" style="color:red">*</label>
                                        <input type="text" name="account_filial"
                                               id="account_filial"
                                               value="{{ old('account_filial') }}"
                                               class="form-control {{ $errors->has('account_filial') ? "is-invalid":"" }}"
                                               autocomplete="off" required>
                                        @if($errors->has('account_filial'))
                                            <span
                                                class="error invalid-feedback">{{ $errors->first('account_filial') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <hr style="background-color: #9f1447; border-width: 2px">

                            <br>
                            <input type="hidden" name="" id="period_key" value="0">
                            <div class="row" id="period_example">
                                <div class="row" id="remove_0">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>@lang('cruds.merchant.merchant_period')</label>
                                            <div style="display: flex">
                                                <input type="number" name="periods[0][merchant_period]"
                                                       value="{{ old('merchant_period') }}"
                                                       class="form-control {{ $errors->has('merchant_period') ? "is-invalid":"" }}"
                                                       autocomplete="off" required>
                                                @if($errors->has('merchant_period'))
                                                    <span
                                                        class="error invalid-feedback">{{ $errors->first('merchant_period') }}</span>
                                                @endif
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>@lang('cruds.merchant.merchant_percentage')</label>
                                            <div style="display: flex">
                                                <input type="number" name="periods[0][merchant_percentage]"
                                                       value="{{ old('merchant_percentage') }}"
                                                       class="form-control {{ $errors->has('merchant_percentage') ? "is-invalid":"" }}"
                                                       autocomplete="off" required>
                                                @if($errors->has('merchant_percentage'))
                                                    <span
                                                        class="error invalid-feedback">{{ $errors->first('merchant_percentage') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <br>
                                        <button class="btn btn-success mt-2 add_period">Add</button>
                                        <button class="btn btn-danger mt-2 remove_period" value="0">Remove</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="period_out">

                            </div>
                            <br>

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
        $(document).on("click", ".add_period", function (event) {
            event.preventDefault();
            var period_key = parseInt($("#period_key").val());
            period_key = period_key + 1;

            var row1 = '<div class = "row" id="remove_' + period_key + '">' +
                '<div class = "col-md-4">' +
                '<div class = "form-group">' +
                '<label>@lang('cruds.merchant.merchant_period')</label>' +
                '<div style="display: flex">' +
                '<input type="number" name="periods[' + period_key + '][merchant_period]" class="form-control" autocomplete="off" required>' +
                '</div>' +
                '</div>' +
                '</div>' +

                '<div class = "col-md-4">' +
                '<div class = "form-group">' +
                '<label>@lang('cruds.merchant.merchant_percentage')</label>' +
                '<div style="display: flex">' +
                '<input type="number" name="periods[' + period_key + '][merchant_percentage]" class="form-control" autocomplete="off" required>' +
                '</div>' +
                '</div>' +
                '</div>' +

                '<div class="col-md-4"> <br>' +
                '<button class="btn btn-success mt-2 add_period">Add</button>' +
                '<button class="btn btn-danger mt-2 remove_period"  value="' + period_key + '">Remove</button>' +
                '</div>' +
                '</div>';

            $("#period_out").append(row1);
            $("#period_key").val(period_key);
        });

        $(document).on("click", ".remove_period", function () {
            var value = $(this).attr("value");
            $("#remove_" + value).remove();
        });

        $(document).on("keyup","#account_number",function (){
            var account = $(this).val();
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:'POST',
                url:'{{ route('getAccountDetails') }}',
                data:{account:account},
                success:function(data) {
                    if(data['status']) {
                        $("#account_filial").val(data['data']['codeFilial']);
                        $("#account_name").val(data['data']['nameAcc']);
                        $("#account_inn").val(data['data']['inn']);
                    }
                }
            });
        });
    </script>
    @endcan
@endsection
