@extends('layouts.admin')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="card-title">
                        <h1>@lang('cruds.report.report')</h1>
                    </h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('global.home')</a></li>
                        <li class="breadcrumb-item active">@lang('cruds.report.report')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- /.card -->
            <div class="card card-primary card-outline">
                <div class="card-header">
                </div>
                <div class="card-body">
                    <h4>Custom Content Below</h4>
                    <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="custom-content-below-home-tab" data-toggle="pill"
                               href="#custom-content-below-home" role="tab" aria-controls="custom-content-below-home"
                               aria-selected="true">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-content-below-profile-tab" data-toggle="pill"
                               href="#custom-content-below-profile" role="tab"
                               aria-controls="custom-content-below-profile" aria-selected="false">Profile</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="custom-content-below-tabContent">
                        <div class="tab-pane fade show active" id="custom-content-below-home" role="tabpanel"
                             aria-labelledby="custom-content-below-home-tab">
                            <div class="card">
                                <div class="card-header">
                                    <tr>
                                        <th>@lang('cruds.report.posting_date')</th>
                                        <th>@lang('cruds.report.operation_day_dates')</th>
                                        <th>@lang('cruds.report.operation_day_dates')</th>
                                        <th>@lang('cruds.report.operation_day_dates')</th>
                                        <th>@lang('cruds.report.operation_day_dates')</th>
                                    </tr>
                                </div>
                                <div class="card-body">
                                    <tr>
                                        <td>1</td>
                                        <td>1</td>
                                        <td>1</td>
                                        <td>1</td>
                                    </tr>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="tab-custom-content">
                        <p class="lead mb-0">Custom Content goes here</p>
                    </div>

                </div>
                <!-- /.card -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
