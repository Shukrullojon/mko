@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('cruds.paylater.index')</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('global.home')</a></li>
                        <li class="breadcrumb-item active">@lang('cruds.paylater.index')</li>
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
                        <h3 class="card-title">@lang('cruds.paylater.index')</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <!-- Data table -->
                        <table id="" class="table table-bordered table-striped dataTable dtr-inline" role="grid"
                               aria-describedby="dataTable_info">
                            <thead>
                            <tr>
                                <th>Client</th>
                                <th>Amount</th>
                                <th>IS SENT</th>
                                <th></th>
                            </tr>

                            </thead>
                            <tbody>
                            @foreach($transactions as $transaction)
                                <tr>
                                    <td>
                                        {{ $transaction->payment->client->first_name ?? "" }}
                                        {{ $transaction->payment->client->last_name ?? "" }}</td>
                                    <td>
                                        {{ number_format($transaction->amount/100) }}
                                    </td>
                                    <td>
                                        {{ $transaction->is_sent }}
                                    </td>
                                    <td>
                                        <a href="{{ route("laterSent",$transaction->id) }}" class="btn btn-success">Sent</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <br>
                        {{ $transactions->links() }}
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection
