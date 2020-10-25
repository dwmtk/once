@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">イベント一覧</div>
                    @forelse($event_list as $event)
                        <div><a href="{{ action('EventController@detail', $event->id ) }}">{{ $event->name }}</a></div>
                    @empty
                        <div>イベントが存在しません。</div>
                    @endforelse
                <div class="card-body">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
