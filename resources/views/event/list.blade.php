@extends('layouts.app')

@section('content')
<div class="eventListBlade">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="category-index">
                    <h2>
                        @if( $category == 'manabu' )
                            マナブ
                        @elseif( $category == 'asobu' )
                            アソブ
                        @elseif( $category == 'tsukuru' )
                            ツクル
                        @elseif( $category == 'deau' )
                            デアウ
                        @elseif( $category == 'intention' )
                            intention
                        @endif
                    </h2>
                </div>
                <div class="category-image">
                    @if( $category == 'manabu' )
                        <img src="/img/manabu.jpg" alt="マナブの画像">
                    @elseif( $category == 'asobu' )
                        <img src="/img/asobu.jpg" alt="アソブの画像">
                    @elseif( $category == 'tsukuru' )
                        <img src="/img/tsukuru.jpg" alt="ツクルの画像">
                    @elseif( $category == 'deau' )
                        <img src="/img/deau.jpg" alt="デアウの画像">
                    @elseif( $category == 'intention' )
                        <img src="/img/intention.jpg" alt="インテンションの画像">
                    @endif
                </div>
                @include('layouts.alert')

                <div class="topic"><h3>イベント一覧</h3></div>
                @forelse($event_list as $event)
                    @if( strtotime($event->start) > strtotime("now") )
                        {{-- <div class="card mb-3">
                            <a href="{{ action('EventController@detail', $event->id ) }}" class="card-link">
                                <div class="row no-gutters">
                                    <div class="col-4 card-left">
                                        <div class="card-image">
                                            @if ( !isset($event->image) )
                                            <img src="/img/no_image.jpeg" class="card-img" alt="イメージ画像はありません">
                                            @else
                                            <img src="/storage/event/{{ $event->id }}/{{ $event->image }}" class="card-img" alt="イベント{{ $event->name }}のイメージ画像">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-8 card-right">
                                        <div class="card-body">
                                            <h4 class="card-title">
                                                @if ( mb_strlen($event->name) >= 13)
                                                @php
                                                    $a = mb_substr($event->name,0,12);
                                                @endphp
                                                {{$a}}…
                                                @else
                                                    {{ $event->name }}
                                                @endif
                                            </h4>
                                            <p class="card-text">{{ date('Y年m月d日 H時i分', strtotime($event->start)) }} 開催！</p>
                                            @if ( $event->capacity <= $event->number )
                                                <p class="card-text">※満員です。</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div> --}}
                        <div class="card mb-3">
                            <a href="{{ action('EventController@detail', $event->id ) }}" class="card-link">
                                <div class="row no-gutters">
                                    <div class="col-4 my-auto card-left">
                                            @if ( !isset($event->image) )
                                            <img src="/img/no_image.jpeg" class="card-img" alt="イメージ画像はありません">
                                            @else
                                            <img src="/storage/event/{{ $event->id }}/{{ $event->image }}" class="card-img" alt="イベント{{ $event->name }}のイメージ画像">
                                            @endif
                                    </div>
                                    <div class="col-8 card-right">
                                        <div class="card-body">
                                            <h4 class="card-title">
                                                @if ( mb_strlen($event->name) >= 16)
                                                    @php
                                                        $name = mb_substr($event->name,0,14);
                                                    @endphp
                                                    {{$name}}…
                                                @else
                                                    {{ $event->name }}
                                                @endif
                                            </h4>
                                            <p class="card-text">{{ date('Y年m月d日 H時i分', strtotime($event->start)) }} 開催！</p>
                                            @if ( $event->capacity <= $event->number )
                                                <p class="card-text">※満員です。</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @else
                        <div class="card mb-3">
                            <a href="{{ action('EventController@detail', $event->id ) }}" class="card-link">
                                <div class="row no-gutters">
                                    <div class="col-4 card-left">
                                            @if ( !isset($event->image) )
                                            <img src="/img/no_image.jpeg" class="card-img" alt="イメージ画像はありません">
                                            @else
                                            <img src="/storage/event/{{ $event->id }}/{{ $event->image }}" class="card-img" alt="イベント{{ $event->name }}のイメージ画像">
                                            @endif
                                    </div>
                                    <div class="col-8 card-right">
                                        <div class="card-body">
                                            <h4 class="card-title">{{ $event->name }}</h4>
                                            <p class="card-text">開催済みのイベントです。</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                @empty
                    <div class="no-card">まだイベントがありません。<br>今後のイベントを楽しみにお待ちください！</div>
                @endforelse

            </div>
        </div>
    </div>
</div>
@endsection
