@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">利用者一覧</div>
                <div class="card-body">
                    <ul class="list-group">
                    @forelse($users as $user)
                        <li class="list-group-item">
                            <div class="">
                            {{ $user->name }}（{{ $user->nickname }}）
                            </div>
                            <div><small class="text-secondary">
                            @if( $user->sex )
                                男性
                            @else
                                女性
                            @endif
                             ／ {{  $user->email }} ／ 
                            @foreach(config('prefs') as $key => $pref) 
                                @if($key == $user->prefecture)
                                    {{ $pref }}
                                @endif
                            @endforeach
                            {{ $user->city }} ／ {{ $user->work }} ／ 登録：{{ $user->created_at }} ／ 更新：{{ $user->updated_at }} ／ 
                            @if( $user->user_type == 1)
                            一般
                            @else
                            管理者
                            @endif
                            </small></div>
                        </li>
                    @empty
                        <li class="list-group-item">参加者はいません</li>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
