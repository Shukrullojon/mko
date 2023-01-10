@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('cruds.client.clients')</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('global.home')</a></li>
                        <li class="breadcrumb-item active">@lang('cruds.client.clients')</li>
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
                        <h3 class="card-title">@lang('cruds.client.clients')</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <!-- Data table -->
                        <table id="" class="table table-bordered table-striped dataTable dtr-inline" role="grid"
                               aria-describedby="dataTable_info">
                            <thead>
                            <tr>
                                <th>Fio</th>
                                <th>Limit</th>
                                <th>Card</th>
                                <th>Date expiry</th>
                                <th>Status</th>
                                <th></th>
                            </tr>

                            </thead>
                            <tbody>
                            @foreach($clients as $client)
                                <tr>
                                    <td>
                                        {{ $client->first_name }} {{ $client->last_name }}
                                    </td>

                                    <td>
                                        {{ number_format($client->limit/100) }} UZS
                                    </td>

                                    <td>{{ $client->card->number }}</td>
                                    <td>{{ $client->date_expiry }}</td>

                                    <td>
                                        {{ $client->status }}
                                    </td>

                                    <td>
                                        <a href="{{ route('clientShow',$client->id) }}"
                                           class="btn btn-info btn-sm">
                                            <span class="fa fa-eye"></span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <br>
                        {{ $clients->links() }}
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
