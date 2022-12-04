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
                        <li class="breadcrumb-item"><a href="{{ route('accountIndex') }}">@lang('global.add')</a></li>
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

                        <form action="{{ route('accountStore') }}" method="post">
                            @csrf

                            <div class="form-group">
                                <label>@lang('cruds.account.number')</label>
                                <input type="number" name="number" value="{{ old('number') }}" class="form-control {{ $errors->has('number') ? "is-invalid":"" }}" autocomplete="off" required>
                                @if($errors->has('number'))
                                    <span class="error invalid-feedback">{{ $errors->first('number') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>@lang('cruds.account.name')</label>
                                <input type="text" name="name" value="{{ old('name') }}" class="form-control {{ $errors->has('name') ? "is-invalid":"" }}" autocomplete="off" required>
                                @if($errors->has('name'))
                                    <span class="error invalid-feedback">{{ $errors->first('name') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>@lang('cruds.account.inn')</label>
                                <input type="text" name="inn" value="{{ old('inn') }}" class="form-control {{ $errors->has('inn') ? "is-invalid":"" }}" autocomplete="off" required>
                                @if($errors->has('inn'))
                                    <span class="error invalid-feedback">{{ $errors->first('inn') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>@lang('cruds.account.filial')</label>
                                <input type="text" name="filial" value="{{ old('filial') }}" class="form-control {{ $errors->has('filial') ? "is-invalid":"" }}" autocomplete="off" required>
                                @if($errors->has('filial'))
                                    <span class="error invalid-feedback">{{ $errors->first('filial') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>@lang('cruds.account.percentage')</label>
                                <input type="number" name="percentage" value="{{ old('percentage') }}" class="form-control {{ $errors->has('percentage') ? "is-invalid":"" }}" autocomplete="off" required>
                                @if($errors->has('percentage'))
                                    <span class="error invalid-feedback">{{ $errors->first('percentage') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-success float-right">@lang('global.save')</button>
                                <a href="{{ route('accountIndex') }}" class="btn btn-default float-left">@lang('global.cancel')</a>
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
        $(document).on("click","#card",function (){
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:'POST',
                data:{name:name,},
                url:'{{ route('createAccCard') }}',
                success:function(data){
                    if(data){
                        $("#card").html('');
                    }else{
                        console.log(data);
                        alert(data['message'])
                    }
                }
            });
        });
    </script>
@endsection
