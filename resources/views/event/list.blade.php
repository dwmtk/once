@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    イベント一覧 [
                    @if( $event_list[0]->category == 'manabu' )
                    マナブ
                    @elseif( $event_list[0]->category == 'asobu' )
                    アソブ
                    @elseif( $event_list[0]->category == 'tsukuru' )
                    ツクル
                    @elseif( $event_list[0]->category == 'deau' )
                    デアウ
                    @elseif( $event_list[0]->category == 'intention' )
                    intention
                    @endif    
                    ]
                </div>
                @include('layouts.alert')
                <div class="card-body">
                    @forelse($event_list as $event)
                        <div><a href="{{ action('EventController@detail', $event->id ) }}">{{ $event->name }}</a></div>
                    @empty
                        <div>イベントが存在しません。</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
