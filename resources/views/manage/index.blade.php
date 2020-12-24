@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">管理者ページ<a href="{{ url('manage/howto') }}" class="float-right badge badge-info text-light mt-1">このページの使い方</a></div>
                @include('layouts.alert')
                <div class="card-body">
                    <h5>利用者一覧</h5>
                    <a href="{{ url('manage/member_list') }}">・利用者一覧</a>
                    <h5 class="mt-4">イベント一覧</h5>　
                    <a class="btn btn-sm btn-primary mb-2" href="{{ url('manage/insert') }}">イベントを新規作成</a>
                    <div class="list-group">
                    @forelse($events as $event)
                        <a href="{{ action('ManageController@update_get', $event->id) }}" class="list-group-item list-group-item-action">
                            {{--
                            @if( $event->capacity <= $event->number )
                                <div class="float-right badge badge-danger">満員</div>
                            @endif
                            --}}

                            @if( intval($event->end) < intval(date('YmdHi')) )
                                <div class="float-right badge badge-secondary">開催済み</div>
                            @endif
                            
                            <div>
                                {{ $event->name }}
                                @if( $event->category == 'manabu' )
                                <div class="badge badge-warning">マナブ</div>
                                @elseif( $event->category == 'asobu' )
                                <div class="badge badge-warning">アソブ</div>
                                @elseif( $event->category == 'tsukuru' )
                                <div class="badge badge-warning">ツクル</div>
                                @elseif( $event->category == 'deau' )
                                <div class="badge badge-warning">デアウ</div>
                                @elseif( $event->category == 'intention' )
                                <div class="badge badge-warning">intention</div>
                                @endif
                            </div>
                            <small class="d-block float-md-left
                            @if( $event->capacity > $event->number )
                                text-secondary
                            @else
                                text-danger font-weight-bold
                            @endif
                            ">
                                定員：{{ $event->capacity }}人／参加：{{ $event->number }}人
                            </small>
                            <small class="text-secondary float-md-right d-block">開催日：{{ date('Y/m/d H:i', strtotime($event->start)) }} ~ {{ date('Y/m/d H:i', strtotime($event->end)) }}</small>
                        </a>
                    @empty
                        ・イベントが存在しません
                    @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
