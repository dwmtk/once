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
                <div class="topic"><h3>イベント詳細</h3></div>

                @include('layouts.alert')

                @if( strtotime($event->start) <= strtotime("now") )
                    {{-- 開催済み --}}
                    <div class="alert alert-secondary">開催済みのイベントです。</div>
                @else
                    {{-- 開催前 --}}
                    @if($event->stop_flg == 1)
                        <div class="alert alert-warning">このイベントは募集が打ち切られました。</div>
                    @endif
                    @if( $event->capacity <= $event->number )
                        <div class="alert alert-info">このイベントは現在満員です。</div>
                    @endif
                    @if(Auth::check())
                        @if($attend_log == 0)
                            {{-- 未欠席 --}}
                            <div class="alert alert-info">参加済みのイベントです。</div>
                        @elseif($attend_log == 1)
                            {{-- 欠席済み --}}
                            <div class="alert alert-info">欠席済みのイベントです。</div>
                        @endif
                    @endif
                @endif

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
                    <dd>{{ date('Y年m月d日 H時i分', strtotime($event->start)) }} ~ {{ date('Y年m月d日 H時i分', strtotime($event->end)) }}</dd>
                    <dt>開催場所</dt>
                    <dd>{{ $event->place }}</dd>
                    <dt>定員 / 参加予定人数</dt>
                    <dd>{{ $event->capacity }}人 / {{ $event->number }}人</dd>
                    <dt>参加費</dt>
                    <dd>{{ number_format($event->fee) }}円</dd>
                    <dt>イベント参加条件</dt>
                    <dd>
                        <ul>
                            <li>貴重品は各自で責任もって管理して下さい。紛失等の責任は負い兼ねます。</li>
                            <li>未成年のお酒の提供は致しません。</li>
                            <li>飲酒運転は、法律で固く禁止されています。飲酒運転は、ご遠慮ください。</li>
                            <li>途中参加、途中退室可能ですが、料金は一律いただきます。</li>
                            <li>人数により会場が混雑する可能性がありますので、早めの行動をお願い致します。</li>
                            <li>会費を渡す際、お釣りが出ないようにご協力を宜しくお願い致します。</li>
                            <li>参加者同士のトラブルや問題は責任を負い兼ねますの極力ないようにお願い致します。</li>
                            <li>ネットワークビジネスや宗教勧誘、その他勧誘行為は絶対にご遠慮ください。発覚した場合、今後の交流会の出入りを禁止とさせていただきます。</li>
                            <li>他の参加者の個人情報の漏洩は絶対にいたしません。</li>
                        </ul>
                    </dd>
                </dl>
                <div class="text-center">
                    <div class="d-inline-flex">
                        <form method="POST" action="{{ url('event/end') }}" onSubmit="return dialog('イベントに参加しますか？')">
                            @csrf
                            <input type="submit" class="btn btn-abled" value="参加する" {{ $attend_btn }}>
                            <input type="hidden" name="event_id" value="{{ $event->id }}">
                        </form>
                        @if(Auth::check())
                            <form method="POST" action="{{ url('event/quit') }}" class="ml-1 d-{{ $quit_btn }}" onSubmit="return dialog('イベントを欠席しますか？')">
                                @csrf
                                <input type="submit" class="btn btn-abled" value="欠席する">
                                <input type="hidden" name="event_id" value="{{ $event->id }}">
                                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                            </form>
                        @else
                            <p class="btn-message">参加するには会員登録をお願いします。</p>
                        @endif
                    </div>
                </div>
                <dl class="event-detail mt-3">
                    <dt>参加者一覧</dt>
                    <dd>
                        <ul>
                        @forelse($attends as $attend)
                            <li>{{ $attend->nickname }}（@if($attend->sex == 1)男性@else女性@endif／{{ $attend->work }}）</li>
                        @empty
                            <li>参加者はまだ居ません</li>
                        @endforelse
                        </ul>
                    </dd>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection
