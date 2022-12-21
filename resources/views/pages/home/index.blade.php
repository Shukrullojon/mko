@extends('layouts.admin')

@section('content')
    <br>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        @if($card)
                            <h3>{{ $card->owner ?? "" }}</h3>
                            <p>{{ number_format($card->balance/100) }} UZS</p>
                        @endif
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="" class="small-box-footer"></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        @if($accountItUnisoft)
                            <h3>It Unisoft</h3>
                            <p>{{ number_format($accountItUnisoft->card->balance/100) }} UZS</p>
                        @endif
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="" class="small-box-footer"></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        @if($accountMko)
                            <h3>Mko</h3>
                            <p>{{ number_format($accountMko->card->balance/100) }} UZS</p>
                        @endif
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="" class="small-box-footer"></a>
                </div>
            </div>
        </div>
    </div>
@endsection
