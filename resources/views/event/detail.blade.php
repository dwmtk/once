@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">イベント詳細</div>
                @include('layouts.alert')
                <div class="card-body">

                <h1>{{ $event->name }}</h1>
                <div>開催日：{{ date('Y/m/d H:i', strtotime($event->start)) }} ~ {{ date('Y/m/d H:i', strtotime($event->end)) }}</div>
                <div>定員：{{ $event->capacity }}人／参加：{{ $event->number }}人</div>
                <div class="text-center" style="width:100%;">
                    <img src="/storage/event/{{ $event->id }}/{{ $event->image }}" style="width:100%;">
                </div>
                <div>イベント内容：</div>
                <p>{!! nl2br($event->content) !!}</p>
                @if( $event->capacity > $event->number )
                    @if( strtotime($event->start) > strtotime("now") )
                        @if(Auth::check())
                            <form method="POST" action="{{ url('event/end') }}" onSubmit="return dialog('イベントに参加しますか？')">
                                @csrf
                                <input type="submit" class="btn btn-primary" value="参加する">
                                <input type="hidden" name="event_id" value="{{ $event->id }}">
                            </form>
                        @else
                            <button class="btn btn-primary" disabled>参加する</button>
                            参加するには会員登録をお願いします。
                        @endif
                    @else
                        <button class="btn btn-primary" disabled>参加する</button>
                        開催済みのイベントです。
                    @endif
                @else
                    <button class="btn btn-danger" disabled>満員です</button>
                @endif
                <div class="mt-3">
                    <h5>参加者一覧</h5>
                    @forelse($attends as $attend)
                        <p>・{{ $attend->nickname }}</p>
                    @empty
                        <p>・参加者は居ません</p>
                    @endforelse
                </div>
                
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
