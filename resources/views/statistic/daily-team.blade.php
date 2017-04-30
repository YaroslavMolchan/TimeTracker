@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="page-header">
            <h1>Team statistic for today</h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Start date</th>
                        <th>Finish date</th>
                        <th>Total time</th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse($statistics as $statistic)
                            <tr>
                                <td>{!! $statistic['name'] !!}</td>
                                @if(isset($statistic['created_at']))
                                    <td>{!! $statistic['created_at'] !!}</td>
                                    <td>{!! $statistic['finished_at'] !!}</td>
                                    <td><span class="grid-timer" data-seconds="{!! $statistic['total']['seconds'] !!}" data-is_active="{!! $statistic['total']['is_active'] !!}"></span></td>
                                @else
                                    <td colspan="3">Not working today</td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">Today nobody has worked yet</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="/js/timer.jquery.min.js"></script>
<script>
    $(function() {
        $('.grid-timer').each(function(index, el) {
            $(el).timer({
                seconds: $(el).data('seconds'),
                format: '%H:%M:%S'
            });
            if ($(el).data('is_active') === 0) {
                $(el).timer('pause');
            }
        });
    });
</script>
@endpush