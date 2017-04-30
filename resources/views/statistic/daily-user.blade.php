@forelse($times as $time)
    <p>{!! $time->started_at->toTimeString() !!} - {!! !is_null($time->finished_at) ? $time->finished_at->toTimeString() : 'now' !!}</p>
@empty
    Today nobody has worked yet
@endforelse