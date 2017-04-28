@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="outer-div text-center">
                <h1><i class="fa fa-clock-o" aria-hidden="true"></i></h1>
                <div class="col-md-12 tweet">
                    <ul class="list">
                        @if(!\Auth::check())
                            <li><a href="{!! route('login') !!}"><i class="fa fa-sign-in" aria-hidden="true"></i></a></li>
                        @else
                            <li><a href="{!! route('login') !!}"><i class="fa fa-play" aria-hidden="true"></i></a></li>
                        @endif
                        <li><i class="fa fa-bar-chart" aria-hidden="true"></i></li>
                        <li><i class="fa fa-info" aria-hidden="true"></i></li>
                    </ul>
                </div>

                <div class="col-md-12 tweet">
                    <p>Вы работаете 4 часа с 09:30</p>
                    <p>Вы работаете 4 часа с 09:30</p>
                    <p>Вы работаете 4 часа с 09:30</p>
                </div>
            </div>
        </div>
    </div>
@endsection