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
                            <h2 class="text-center" style="color: #00b44e">Информация о Мерчанта</h2>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('cruds.merchant.merchant')</label>
                                        <input type="text" name="merchant" value="{{ old('merchant') }}"
                                               class="form-control {{ $errors->has('merchant') ? "is-invalid":"" }}"
                                               autocomplete="off" required>
                                        @if($errors->has('merchant'))
                                            <span class="error invalid-feedback">{{ $errors->first('merchant') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('cruds.merchant.terminal')</label>
                                        <input type="text" name="terminal" value="{{ old('terminal') }}"
                                               class="form-control {{ $errors->has('terminal') ? "is-invalid":"" }}"
                                               autocomplete="off" required>
                                        @if($errors->has('terminal'))
                                            <span class="error invalid-feedback">{{ $errors->first('terminal') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>@lang('cruds.merchant.brand_id')</label>
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
                                        <label>@lang('cruds.merchant.merchant_name')</label>
                                        <input type="text" name="merchant_name" value="{{ old('merchant_name') }}"
                                               class="form-control {{ $errors->has('merchant_name') ? "is-invalid":"" }}"
                                               autocomplete="off" required>
                                        @if($errors->has('merchant_name'))
                                            <span
                                                class="error invalid-feedback">{{ $errors->first('merchant_name') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>@lang('cruds.merchant.filial')</label>
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
                                        <input type="text" name="merchant_address" value="{{ old('merchant_address') }}"
                                               class="form-control {{ $errors->has('merchant_address') ? "is-invalid":"" }}"
                                               autocomplete="off" required>
                                        @if($errors->has('merchant_address'))
                                            <span
                                                class="error invalid-feedback">{{ $errors->first('merchant_address') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>@lang('cruds.merchant.uzcard_merchant_id')</label>
                                        <input type="text" name="uzcard_merchant_id"
                                               value="{{ old('uzcard_merchant_id') }}"
                                               class="form-control {{ $errors->has('uzcard_merchant_id') ? "is-invalid":"" }}"
                                               autocomplete="off" required>
                                        @if($errors->has('uzcard_merchant_id'))
                                            <span
                                                class="error invalid-feedback">{{ $errors->first('uzcard_merchant_id') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>@lang('cruds.merchant.uzcard_terminal_id')</label>
                                        <input type="text" name="uzcard_terminal_id"
                                               value="{{ old('uzcard_terminal_id') }}"
                                               class="form-control {{ $errors->has('uzcard_terminal_id') ? "is-invalid":"" }}"
                                               autocomplete="off" required>
                                        @if($errors->has('uzcard_terminal_id'))
                                            <span
                                                class="error invalid-feedback">{{ $errors->first('uzcard_terminal_id') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>@lang('cruds.merchant.humo_merchant_id')</label>
                                        <input type="text" name="humo_merchant_id" value="{{ old('humo_merchant_id') }}"
                                               class="form-control {{ $errors->has('humo_merchant_id') ? "is-invalid":"" }}"
                                               autocomplete="off" required>
                                        @if($errors->has('humo_merchant_id'))
                                            <span
                                                class="error invalid-feedback">{{ $errors->first('humo_merchant_id') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>@lang('cruds.merchant.humo_terminal_id')</label>
                                        <input type="text" name="humo_terminal_id" value="{{ old('humo_terminal_id') }}"
                                               class="form-control {{ $errors->has('humo_terminal_id') ? "is-invalid":"" }}"
                                               autocomplete="off" required>
                                        @if($errors->has('humo_terminal_id'))
                                            <span
                                                class="error invalid-feedback">{{ $errors->first('humo_terminal_id') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <br>
                            <h2 class="text-center" style="color: #00b44e">Информация о Перид Мерчанта</h2>
                            <input type="hidden" name="" id="period_key" value="0">

                            <div id="period_example">
                                <div class="row" id="asd0">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>@lang('cruds.merchant.merchant_period')</label>
                                            <div style="display: flex">
                                                <input type="number" name="p[0][merchant_period]"
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
                                                <input type="number" name="p[0][merchant_percentage]"
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
                            <div id="period_out">

                            </div>
                            <br>

                            <h2 class="text-center" style="color: #00b44e">Информация о Cчета</h2>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>@lang('cruds.account.account_number')</label>
                                        <input type="text" name="account_number"
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
                                        <input type="text" name="account_name" value="{{ old('account_name') }}"
                                               class="form-control {{ $errors->has('account_name') ? "is-invalid":"" }}"
                                               autocomplete="off" required>
                                        @if($errors->has('account_name'))
                                            <span
                                                class="error invalid-feedback">{{ $errors->first('account_name') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>@lang('cruds.account.account_inn')</label>
                                        <input type="text" name="account_inn" value="{{ old('account_inn') }}"
                                               class="form-control {{ $errors->has('account_inn') ? "is-invalid":"" }}"
                                               autocomplete="off" required>
                                        @if($errors->has('account_inn'))
                                            <span
                                                class="error invalid-feedback">{{ $errors->first('account_inn') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>@lang('cruds.account.account_filial')</label>
                                        <input type="text" name="account_filial" value="{{ old('account_filial') }}"
                                               class="form-control {{ $errors->has('account_filial') ? "is-invalid":"" }}"
                                               autocomplete="off" required>
                                        @if($errors->has('account_filial'))
                                            <span
                                                class="error invalid-feedback">{{ $errors->first('account_filial') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>@lang('cruds.account.percentage')</label>
                                        <input type="number" name="percentage" value="{{ old('percentage') }}"
                                               class="form-control {{ $errors->has('percentage') ? "is-invalid":"" }}"
                                               autocomplete="off" required>
                                        @if($errors->has('percentage'))
                                            <span
                                                class="error invalid-feedback">{{ $errors->first('percentage') }}</span>
                                        @endif
                                    </div>
                                </div>
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
        $(document).on("click", ".add_period", function () {
            var period_key = parseInt($("#period_key").val());
            period_key = period_key + 1;

            var w = '<div class = "row" id="asd' + period_key + '">' +
                '<div class = "col-md-4">' +
                '<div class = "form-group">' +
                '<label>@lang('cruds.merchant.merchant_period')</label>' +
                '<div style="display: flex">' +
                '<input type="number" name="p[' + period_key + '][merchant_period]" class="form-control" autocomplete="off" required>' +
                '</div>' +
                '</div>' +
                '</div>' +

                '<div class = "col-md-4">' +
                '<div class = "form-group">' +
                '<label>@lang('cruds.merchant.merchant_percentage')</label>' +
                '<div style="display: flex">' +
                '<input type="number" name="p[' + period_key + '][merchant_percentage]" class="form-control" autocomplete="off" required>' +
                '</div>' +
                '</div>' +
                '</div>' +

                '<div class="col-md-4"> <br>' +
                '<button class="btn btn-success mt-2 add_period">Add</button>' +
                '<button class="btn btn-danger mt-2 remove_period"  value="' + period_key + '">Remove</button>' +
                '</div>' +
                '</div>';

            $("#period_out").append(w);
            $("#period_key").val(period_key);
        });

        $(document).on("click", ".remove_period", function () {
            var value = $(this).attr("value");
            $("#asd" + value).remove();
        });

        /*document.getElementById("add").onclick = function (e)
            {
                e.preventDefault();

                var container = document.getElementById("container");
                var section = document.getElementById("mainsection");
                container.appendChild(section.cloneNode(true));
            }
        */
    </script>
@endsection
