@extends('layouts.app')

@section('content')
<div class="eventListBlade">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card-body">
                    <div class="topic mt-4">
                      <h3>参加イベント一覧</h3>
                    </div>
                </div>
                @include('layouts.alert')
                @forelse($my_events as $my_event)
                    <div class="card mb-3">
                        <a href="{{ action('EventController@detail', $my_event->event_id ) }}" class="card-link">
                            <div class="row no-gutters">
                                <div class="col-4 my-auto card-left">
                                    @if ( !isset($my_event->image) )
                                    <img src="/img/no_image.jpeg" class="card-img" alt="イメージ画像はありません">
                                    @else
                                    <img src="/storage/event/{{ $my_event->event_id }}/{{ $my_event->image }}" class="card-img" alt="イベント{{ $my_event->name }}のイメージ画像">
                                    @endif
                                </div>
                                <div class="col-8 card-right">
                                    <div class="card-body">
                                    @if( strtotime($my_event->start) > strtotime("now") )
                                        <h4 class="card-title">
                                            @if ( mb_strlen($my_event->name) >= 16)
                                                @php
                                                    $name = mb_substr($my_event->name,0,14);
                                                @endphp
                                                {{$name}}…
                                            @else
                                                {{ $my_event->name }}
                                            @endif
                                            @if($my_event->quit_flg == 1)
                                                <small><span class="badge badge-secondary">欠席</span></small>
                                            @endif
                                        </h4>
                                        <p class="card-text bottom">{{ date('Y年m月d日 H時i分', strtotime($my_event->start)) }} 開催！</p>        
                                    @else
                                        <h4 class="card-title">
                                            {{ $my_event->name }}
                                            @if($my_event->quit_flg == 1)
                                                <small><span class="badge badge-secondary">欠席</span></small>
                                            @endif
                                        </h4>
                                        <p class="card-text">開催済みのイベントです。</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @empty
                <div class="text-center">
                過去参加したイベントはありません。
                </div>
                @endforelse

            </div>
        </div>
    </div>
</div>
@endsection
