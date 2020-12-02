<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>イベントサイトonce</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 50px;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
            #calendar{
                max-width: 800px;
                margin: 0 auto;
            }
            @media(max-width: 768px){
                #calendar{
                    margin: 0 10px;
                }
                .fc-toolbar{
                    font-size: 10px;
                }
                .fc-widget-header{
                    font-size: 10px;
                }
            }
        </style>

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
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
        <div>
            <div class="content" style="margin: 50px 0;">
                <a href="{{ action('EventController@list', 'manabu') }}">マナブ</a>
                <a href="{{ action('EventController@list', 'asobu') }}">アソブ</a>
                <a href="{{ action('EventController@list', 'tsukuru') }}">ツクル</a>
                <a href="{{ action('EventController@list', 'deau') }}">デアウ</a>
                <a href="{{ action('EventController@list', 'intention') }}">intention</a>
            </div>
            test
            <div id="calendar"></div>
        </div>

        <footer>
            <ul>
                <li><a href="{{ url('/terms_of_service') }}">利用規約</a></li>
                <li><a href="{{ url('/privacy_policy') }}">プライバシーポリシー</a></li>
            </ul>
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
                        color: @if($event->category == 'manabu')'#ff0000'
                        @elseif($event->category == 'asobu')'#ff0000'
                        @elseif($event->category == 'tsukuru')'#008000'
                        @elseif($event->category == 'deau')'#0000ff'
                        @elseif($event->category == 'intention')'#808080'
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
