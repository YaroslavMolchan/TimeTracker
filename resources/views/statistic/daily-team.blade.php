@forelse($statistics as $statistic)
    <p>{!! $statistic->user->name !!} started working at {!! $statistic->created_at->toTimeString() !!}</p>
@empty
    Today nobody has worked yet
@endforelse