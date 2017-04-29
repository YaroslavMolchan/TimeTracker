@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="outer-div text-center">
                <h1><i class="fa fa-clock-o" aria-hidden="true"></i></h1>
                @if(\Auth::check())
                    <h1 id="work-timer" class="work-timer"></h1>
                @endif
                
                <div class="col-md-12 tweet">
                    <ul class="list">
                        @if(!\Auth::check())
                            <li><a href="{!! route('login') !!}"><i class="fa fa-sign-in" aria-hidden="true"></i></a></li>
                        @else
                            @include('timer.buttons.'.$action)
                        @endif
                        <li><i class="fa fa-bar-chart" aria-hidden="true"></i></li>
                        <li><i class="fa fa-info" aria-hidden="true"></i></li>
                    </ul>
                </div>

                <div class="col-md-12 tweet">
                    @if(!is_null($user))
                        @foreach($user->statistics->times as $time)
                            <p>Начал: {!! $time->started_at !!}. Закончил: {!! $time->finished_at !!}. Время работы: {!! $time->total !!}</p>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="/js/timer.jquery.min.js"></script>
<script src="/js/timer.js"></script>
@endpush