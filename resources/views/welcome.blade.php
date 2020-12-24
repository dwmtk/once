<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>イベントサイトonce</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <link href='/css/fullcalendar/core/main.css' rel='stylesheet' />
        <link href='/css/fullcalendar/daygrid/main.css' rel='stylesheet' />
        <link href='/css/fullcalendar/timegrid/main.css' rel='stylesheet' />
        <link href='/css/fullcalendar/list/main.css' rel='stylesheet' />
        <script src='/js/fullcalendar/core/main.js'></script>
        <script src='/js/fullcalendar/interaction/main.js'></script>
        <script src='/js/fullcalendar/daygrid/main.js'></script>
        <script src='/js/fullcalendar/timegrid/main.js'></script>
        <script src='/js/fullcalendar/list/main.js'></script>
        <script src="/js/fullcalendar/core/locales-all.js"></script>
    </head>

    <body class="welcomeBlade">
        <header>
            <div class="container header">
                <div class="header-left">
                    <h1 class="header-link header-left-link"><a href="#">once</a></h1>
                </div>
                <div class="header-right">
                    @if (Route::has('login'))
                        @auth
                            <div class="header-link header-right-link"><a href="{{ url('/home') }}">マイページ</a></div>
                        @else
                            <div class="header-link header-right-link"><a href="{{ route('login') }}">ログイン</a></div>
                                @if (Route::has('register'))
                                    <div class="header-link header-right-link"><a href="{{ route('register') }}">アカウントを作成</a></div>
                                @endif
                        @endauth
                    @endif
                </div>
            </div>
        </header>

        <div class="container categories">
            <h2 class="topic">イベントカテゴリー</h2>
            <div class="row justify-content-center">
                <div class="col-6 category">
                    <a href="{{ action('EventController@list', 'manabu') }}">
                        <div class="category-image"><img src="/img/manabu.jpg" alt="マナブの画像"></div>
                        <p class="category-index">マナブ</p>
                    </a>
                </div>
                <div class="col-6 category">
                    <a href="{{ action('EventController@list', 'asobu') }}">
                        <div class="category-image"><img src="/img/asobu.jpg" alt="アソブの画像"></div>
                        <p class="category-index">アソブ</p>
                    </a>
                </div>
                <div class="col-6 category">
                    <a href="{{ action('EventController@list', 'tsukuru') }}">
                        <div class="category-image"><img src="/img/tsukuru.jpg" alt="ツクルの画像"></div>
                        <p class="category-index">ツクル</p>
                    </a>
                </div>
                <div class="col-6 category">
                    <a href="{{ action('EventController@list', 'deau') }}">
                        <div class="category-image"><img src="/img/deau.jpg" alt="デアウの画像"></div>
                        <p class="category-index">デアウ</p>
                    </a>
                </div>
                <div class="col-6 category">
                    <a href="{{ action('EventController@list', 'intention') }}">
                        <div class="category-image"><img src="/img/intention.jpg" alt="インテンションの画像"></div>
                        <p class="category-index">intention</p>
                    </a>
                </div>
                <div class="col-6 category"></div>
            </div>
        </div>

        <div class="container calendar">
            <h2 class="topic">イベントカレンダー</h2>
            <div class="mt-2 mb-4 h5">
                <span class="badge badge-primary">マナブ</span>
                <span class="badge badge-warning">アソブ</span>
                <span class="badge badge-success">ツクル</span>
                <span class="badge badge-danger">デアウ</span>
                <span class="badge badge-secondary">intention</span>
            </div>
            <div id="calendar"></div>
        </div>

        <footer>
            <div class="container footer">
                <ul class="footer-lists">
                    <li class="footer-link"><a href="">利用規約</a></li>
                    <li class="footer-link"><a href="">プライバシーポリシー</a></li>
                    <!-- <li class="footer-link"><a href="{{ url('/terms_of_service') }}">利用規約</a></li>
                    <li class="footer-link"><a href="{{ url('/privacy_policy') }}">プライバシーポリシー</a></li> -->
                </ul>
            </div>
        </footer>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
                    header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                    },
                    timeZone: 'Asia/Tokyo',
                    locale: 'ja',
                    defaultDate: '{{ date("Y-m-d") }}',
                    navLinks: true, // can click day/week names to navigate views
                    businessHours: false, // display business hours
                    editable: true,
                    events: [
                        @foreach($events as $event)
                        {
                            id: '{{ $event->id }}',
                            title: '{{$event->name}}',
                            start: '{{ date("c",strtotime($event->start)) }}',
                            end: '{{ date("c",strtotime($event->end)) }}',
                            color: @if($event->category == 'manabu')'#007bff'
                            @elseif($event->category == 'asobu')'#ffc107'
                            @elseif($event->category == 'tsukuru')'#28a745'
                            @elseif($event->category == 'deau')'#dc3545'
                            @elseif($event->category == 'intention')'#6c757d'
                            @endif,
                            eventClick: function (info) {
                            }
                        },
                        @endforeach
                    ],
                    eventRender: function(info) {
                        info.el.onclick=function(){
                            var url = '{{ url("event/detail") }}/' + info.event.id;
                            window.location.href = url;
                        }
                    },
                    eventTimeFormat: { hour: 'numeric', minute: '2-digit' }
                });
                calendar.render();
            });
        </script>
    </body>
</html>
