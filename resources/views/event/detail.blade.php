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
            </div>
        </div>
    </div>
</div>
@endsection
