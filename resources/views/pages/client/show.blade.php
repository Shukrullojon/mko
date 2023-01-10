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
                        <li class="breadcrumb-item active"><a href="{{ route('clientIndex') }}">@lang('cruds.client.clients')</a></li>
                        <li class="breadcrumb-item active">@lang('global.edit')</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->

    <section class="content">
        <div class="row">
            <div class="col-md-12 ">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">@lang('global.show')</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="" class="table table-bordered table-striped dataTable dtr-inline" role="grid" aria-describedby="">
                            <thead>
                            <tr>
                                <th>FIO</th>
                                <td>{{ $client->first_name }} {{ $client->last_name }} {{ $client->middle_name }}</td>
                            </tr>

                            <tr>
                                <th>Pnfl</th>
                                <td>{{ $client->pnfl }}</td>
                            </tr>

                            <tr>
                                <th>Passport</th>
                                <td>{{ $client->passport }}</td>
                            </tr>

                            <tr>
                                <th>Application ID</th>
                                <td>{{ $client->application_id }}</td>
                            </tr>

                            <tr>
                                <th>Client Code</th>
                                <td>{{ $client->client_code }}</td>
                            </tr>

                            <tr>
                                <th>Card</th>
                                <td>{{ $client->card->number ?? "" }}</td>
                            </tr>

                            <tr>
                                <th>Balance</th>
                                <td>{{ number_format($client->card->balance/100) ?? "" }} UZS</td>
                            </tr>

                            <tr>
                                <th>Date Expiry</th>
                                <td>{{ $client->card->expiry ?? "" }}</td>
                            </tr>

                            <tr>
                                <th>Limit</th>
                                <td>{{ number_format($client->limit/100) }} UZS</td>
                            </tr>

                            <tr>
                                <th>Limit Status</th>
                                <td>{{ $client->limit_status }}</td>
                            </tr>

                            <tr>
                                <th>Used Limit</th>
                                <td>{{ $client->used_limit }}</td>
                            </tr>

                            <tr>
                                <th>Limit Expiry</th>
                                <td>{{ $client->limit_expiry }}</td>
                            </tr>

                            <tr>
                                <th>Status</th>
                                <th>
                                    @lang('cruds.status.'.$client->status)
                                </th>
                            </tr>

                            </thead>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
