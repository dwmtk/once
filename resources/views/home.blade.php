@extends('layouts.app')

@section('content')
<div class="eventListBlade">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
@include('layouts.alert')
                <div class="card-body">
                    <div class="topic">
                      <h3>参加イベント一覧</h3>
                    </div>
                </div>
                @forelse($my_events as $my_event)
                    @if( strtotime($my_event->start) > strtotime("now") )
                          <div class="card mb-3">
                              <div class="card-link">
                                  <a href="{{ action('EventController@detail', $my_event->id ) }}" class="card-link">
                                      <div class="row no-gutters">
                                          <div class="col-4 my-auto card-left">
                                                  @if ( !isset($my_event->image) )
                                                  <img src="/img/no_image.jpeg" class="card-img" alt="イメージ画像はありません">
                                                  @else
                                                  <img src="/storage/event/{{ $my_event->id }}/{{ $my_event->image }}" class="card-img" alt="イベント{{ $my_event->name }}のイメージ画像">
                                                  @endif
                                          </div>
                                          <div class="col-8 card-right">
                                              <div class="card-body">
                                                  <h4 class="card-title">
                                                      @if ( mb_strlen($my_event->name) >= 16)
                                                          @php
                                                              $name = mb_substr($my_event->name,0,14);
                                                          @endphp
                                                          {{$name}}…
                                                      @else
                                                          {{ $my_event->name }}
                                                      @endif
                                                  </h4>
                                                  <p class="card-text bottom">{{ date('Y年m月d日 H時i分', strtotime($my_event->start)) }} 開催！</p>
                                              </div>
                                          </div>
                                      </div>
                                  </a>
                              </div>
                          </div>
                    @else
                        <div class="card mb-3">
                            <div class="card-link">
                                <a href="{{ action('EventController@detail', $my_event->id ) }}">
                                    <div class="row no-gutters">
                                        <div class="col-4 card-left">
                                                @if ( !isset($my_event->image) )
                                                <img src="/img/no_image.jpeg" class="card-img" alt="イメージ画像はありません">
                                                @else
                                                <img src="/storage/event/{{ $my_event->id }}/{{ $my_event->image }}" class="card-img" alt="イベント{{ $my_event->name }}のイメージ画像">
                                                @endif
                                        </div>
                                        <div class="col-8 card-right">
                                            <div class="card-body">
                                                <h4 class="card-title">{{ $my_event->name }}</h4>
                                                <p class="card-text">開催済みのイベントです。</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                @empty
                <div>
                  ・過去参加したイベントはありません。
                </div>
                @endforelse

            </div>
        </div>
    </div>
</div>
@endsection
