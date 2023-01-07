@extends('layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>mko</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('global.home')</a></li>
                        <li class="breadcrumb-item active"><a href="{{ route('mko') }}">mko</a></li>
                        <li class="breadcrumb-item active">@lang('global.show')</li>
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
                        <h3 class="card-title">@lang('global.show')</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table id="" class="table table-bordered table-striped dataTable dtr-inline" role="grid"
                                       aria-describedby="">
                                    <thead>
                                    <tr>
                                        <th>date</th>
                                        <td>{{ $history->date }}</td>
                                    </tr>
                                    <tr>
                                        <th>dtAcc</th>
                                        <td>{{ $history->dtAcc }}</td>
                                    </tr>
                                    <tr>
                                        <th>dtAccName</th>
                                        <td>{{ $history->dtAccName }}</td>
                                    </tr>
                                    <tr>
                                        <th>dtMfo</th>
                                        <td>{{ $history->dtMfo }}</td>
                                    </tr>
                                    <tr>
                                        <th>credit</th>
                                        <td>{{ $history->credit }}</td>
                                    </tr>
                                    <tr>
                                        <th>debit</th>
                                        <td>{{ $history->debit }}</td>
                                    </tr>
                                    <tr>
                                        <th>type</th>
                                        <td>{{ $history->type }}</td>
                                    </tr>
                                    <tr>
                                        <th>pupose</th>
                                        <td>{{ $history->purpose }}</td>
                                    </tr>
                                    <tr>
                                        <th>numberTrans</th>
                                        <td>{{ $history->numberTrans }}</td>
                                    </tr>
                                    <tr>
                                        <th>ctAcc</th>
                                        <td>{{ $history->ctAcc }}</td>
                                    </tr>
                                    <tr>
                                        <th>ctAccName</th>
                                        <td>{{ $history->ctAccName }}</td>
                                    </tr>
                                    <tr>
                                        <th>ctMfo</th>
                                        <td>{{ $history->ctMfo }}</td>
                                    </tr>

                                    </thead>
                                </table>
                            </div>

                            </div>
                        </div>

                        <div>
                            <a href="{{ route('mko') }}" type="button" class="btn btn-danger"> Back</a>
                        </div>

                    </div>
                </div>
            </div>
    </section>

@endsection
