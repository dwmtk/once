@extends('layouts.app')

@section('content')
<div class="listBlade">
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
                        <img src="/storage/event/1/manabu.jpeg" alt="マナブの画像">
                    @elseif( $category == 'asobu' )
                        <img src="/storage/event/1/asobu.jpg" alt="アソブの画像">
                    @elseif( $category == 'tsukuru' )
                        <img src="/storage/event/1/tsukuru.jpeg" alt="ツクルの画像">
                    @elseif( $category == 'deau' )
                        <img src="/storage/event/1/deau.jpeg" alt="デアウの画像">
                    @elseif( $category == 'intention' )
                        <img src="/storage/event/1/intention.jpeg" alt="インテンションの画像">
                    @endif
                </div>
                @include('layouts.alert')

                <div class="card">
                    <div class="card-header">
                    </div>
                    <div class="card-body">
                        @forelse($event_list as $event)
                            <div><a href="{{ action('EventController@detail', $event->id ) }}">{{ $event->name }}</a></div>
                        @empty
                            <div>イベントが存在しません。</div>
                        @endforelse
                    </div>
                </div>

                <div class="card " style="max-width: 540px;">
                    <div class="row no-gutters">
                      <div class="col-4">
                        <svg class="bd-placeholder-img" width="100%" height="250" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: Image"><title>Placeholder</title><rect width="100%" height="100%" fill="#868e96"/><text x="50%" y="50%" fill="#dee2e6" dy=".3em">Image</text></svg>
                      </div>
                      <div class="col-8">
                        <div class="card-body">
                          <h5 class="card-title">Card title</h5>
                          <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                          <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                        </div>
                      </div>
                    </div>
                  </div>

            </div>
        </div>
    </div>
</div>
@endsection
