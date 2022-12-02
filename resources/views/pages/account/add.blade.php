@extends('layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('global.home')</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('accountIndex') }}">Add</a></li>
                        <li class="breadcrumb-item active">@lang('global.add')</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->

    <section class="content">
        <div class="row">
            <div class="col-8 offset-2">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">@lang('global.add')</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <form action="{{ route('accountStore') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label>name</label>
                                <input type="text" name="name" class="form-control" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label>number</label>
                                <input type="text" name="account" class="form-control" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label>type</label>
                                <input type="text" name="url" class="form-control" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label>filial</label>
                                <input type="text" name="token" class="form-control" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label>persentage</label>
                                <input type="number" name="status" class="form-control" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label>Card</label>
                                <input type="number" name="card" class="form-control" autocomplete="off" required>
                                <a href="{{ route('createAccCard') }}" id="card" class="btn btn-default float-left">Card</a>
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
