{{ $user->nickname }}様のイベント欠席が完了しました。

イベント名：{{ $event->name }}
開催日：{{ date('Y/m/d H:i', strtotime($event->start)) }} ~ {{ date('Y/m/d H:i', strtotime($event->end)) }}

イベント詳細ページ：{{ url('/event/detail/') }}/{{ $event->id }}
