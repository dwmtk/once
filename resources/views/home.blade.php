@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">マイページ</div>
                <div class="card-body">
                    @if (session('success_quit'))
                        <div class="container mt-2">
                        <div class="alert alert-danger">
                            {{session('success_quit')}}
                        </div>
                        </div>
                    @endif
                    ・参加イベント一覧
                    @forelse($my_events as $my_event)
                        <div>
                        <a href="{{ action('EventController@detail', $my_event->event_id) }}">{{ $my_event->name }}</a>
                        @if($my_event->quit_flg = 0)
                        <form method="POST" action="{{ url('event/quit') }}" class="d-inline-block">
                        @csrf
                            <input type="submit" class="btn btn-sm btn-primary" value="欠席">
                            <input type="hidden" name="execute" value="on">
                            <input type="hidden" name="id" value="{{ $my_event->id }}">
                        </form>
                        @elseif($my_event->quit_flg = 1)
                        <span class="badge badge-danger">欠席済み</span>
                        @endif
                        </div>
                    @empty
                    ・過去参加したイベントはありません。
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
