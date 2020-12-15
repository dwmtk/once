@extends('layouts.app')

@section('content')
<div class="eventDetailBlade">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="category-index">
                    <h2>
                        @if( $event->category == 'manabu' )
                            マナブ
                        @elseif( $event->category == 'asobu' )
                            アソブ
                        @elseif( $event->category == 'tsukuru' )
                            ツクル
                        @elseif( $event->category == 'deau' )
                            デアウ
                        @elseif( $event->category == 'intention' )
                            intention
                        @endif
                    </h2>
                </div>
                @include('layouts.alert')

                <div class="topic"><h3>イベント詳細</h3></div>

                <div class="event-image">
                    @if ( !isset($event->image) )
                    <img src="/img/no_image.jpeg" alt="イメージ画像はありません">
                    @else
                    <img src="/storage/event/{{ $event->id }}/{{ $event->image }}" alt="イベント{{ $event->name }}のイメージ画像">
                    @endif
                </div>

                <dl class="event-detail">
                    <div class="event-title"><h4>{{ $event->name }}</h4></div>
                    <div class="event-content">{!! nl2br($event->content) !!}</div>
                    <dt>開催日時</dt>
                    <dd>{{ date('Y/m/d H:i', strtotime($event->start)) }} ~ {{ date('Y/m/d H:i', strtotime($event->end)) }}</dd>
                    <dt>開催場所</dt>
                    <dd>{{ $event->place }}</dd>
                    <dt>定員 / 参加予定人数</dt>
                    <dd>{{ $event->capacity }}人 / {{ $event->number }}人</dd>
                    <dt>参加費</dt>
                    <dd>{{ number_format($event->fee) }}円</dd>
                </dl>

                @if( $event->capacity > $event->number )
                    @if( strtotime($event->start) > strtotime("now") )
                        @if(Auth::check())
                            <form method="POST" action="{{ url('event/end') }}" onSubmit="return dialog('イベントに参加しますか？')">
                                @csrf
                                <input type="submit" class="btn btn-abled" value="参加する">
                                <input type="hidden" name="event_id" value="{{ $event->id }}">
                            </form>
                        @else
                            <button class="btn btn-disabled" disabled>参加する</button>
                            <p class="btn-message">参加するには会員登録をお願いします。</p>
                        @endif
                    @else
                        <button class="btn btn-disabled" disabled>参加する</button>
                        <p class="btn-message">開催済みのイベントです。</p>
                    @endif
                @else
                    <button class="btn btn-disabled" disabled>参加する</button>
                    <p class="btn-message">このイベントは現在満員です。</p>
                @endif

                {{-- <div class="card">
                    <div class="card-header">イベント詳細</div>
                    @include('layouts.alert')

                    <div class="card-body">
                        <h1>{{ $event->name }}</h1>
                        <div>カテゴリ：
                            @if( $event->category == 'manabu' )
                            マナブ
                            @elseif( $event->category == 'asobu' )
                            アソブ
                            @elseif( $event->category == 'tsukuru' )
                            ツクル
                            @elseif( $event->category == 'deau' )
                            デアウ
                            @elseif( $event->category == 'intention' )
                            intention
                            @endif
                        </div>
                        <div>開催日：{{ date('Y/m/d H:i', strtotime($event->start)) }} ~ {{ date('Y/m/d H:i', strtotime($event->end)) }}</div>
                        <div>開催場所：{{ $event->place }}</div>
                        <div>定員：{{ $event->capacity }}人／参加：{{ $event->number }}人</div>
                        <div>参加費：{{ number_format($event->fee) }}円</div>
                        @if(!empty($event->image))
                            <div class="text-center" style="width:100%;">
                                <img src="/storage/event/{{ $event->id }}/{{ $event->image }}" style="width:100%;">
                            </div>
                        @endif
                        <div>イベント内容：</div>
                        <hr>
                        <p>{!! nl2br($event->content) !!}</p>
                        <hr>
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
                </div> --}}
            </div>
        </div>
    </div>
</div>
@endsection
