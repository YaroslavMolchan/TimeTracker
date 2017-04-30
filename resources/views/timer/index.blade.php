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
                            <li><a href="{!! route('login') !!}"><i class="fa fa-sign-in"></i></a></li>
                        @else
                            @include('timer.buttons.'.$action)
                        @endif
                        @if(\Auth::check())
                            <li data-toggle="tooltip" data-placement="top" title="Your daily statistic">
                                <a href="{!! route('statistic.daily-user') !!}" class="get-statistic">
                                    <i class="fa fa-info"></i>
                                </a>
                            </li>
                        @endif
                        <li data-toggle="tooltip" data-placement="top" title="Team daily statistic">
                            <a href="{!! route('statistic.daily-team') !!}" class="get-statistic">
                                <i class="fa fa-bar-chart" aria-hidden="true"></i>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="col-md-12 tweet statistic-content">

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="/js/timer.jquery.min.js"></script>
<script src="/js/timer.js"></script>
@endpush