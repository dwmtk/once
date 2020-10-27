@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">イベント詳細・編集画面　<a href="{{ action('ManageController@stop', $event->id) }}" class="btn btn-warning btn-sm disabled">募集を打ち切る※未実装</a></div>
                @if (session('success_update'))
                    <div class="container mt-2">
                    <div class="alert alert-success">
                        {{session('success_update')}}
                    </div>
                    </div>
                @endif
                <div class="card-body">
                <h5>参加者一覧（定員：{{ $event->capacity }}人／参加：{{ $event->number }}人）</h5>
                <ul class="list-group">
                @forelse($attends as $attend)
                    <li class="list-group-item
                    @if($attend->quit_flg == 1)
                        list-group-item-secondary
                    @endif
                    ">
                        @if($attend->quit_flg == 1)
                        <span class="float-right badge badge-secondary ml-1">欠席</span>
                        @endif
                        <div class="float-left">
                        {{$loop->iteration}} ： {{ $attend->name }}（{{ $attend->nickname }}）／ 
                        @if( $attend->sex )
                            男性
                        @else
                            女性
                        @endif
                        </div>
                        <div><small class="text-secondary float-right">
                        {{  $attend->email }} ／ 
                        @foreach(config('prefs') as $key => $pref) 
                            @if($key == $attend->prefecture)
                                {{ $pref }}
                            @endif
                        @endforeach
                        {{ $attend->city }} ／ {{ $attend->work }}
                        </small></div>
                    </li>
                @empty
                    <li class="list-group-item">参加者はいません</li>
                @endforelse
                </ul>
                <h5 class="mt-4">イベント詳細・編集　<a class="btn btn-sm btn-outline-secondary" href="{{ action('EventController@detail', $event->id) }}">詳細画面</a></h5>
                <form method="POST" action="{{ url('manage/update') }}" class="col-md-12">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="col-md-3 col-form-label">イベント名</label>
                        <input id="name" type="text" class="col-md-12 form-control @error('name') is-invalid @enderror" name="name" value="{{ $event->name }}" required>
                    </div>
                    <div class="form-group">
                        <label for="category" class="col-md-3 col-form-label">カテゴリ</label>
                        <select id="category" class="col-md-12 form-control @error('category') is-invalid @enderror" type="text" name="category" value="{{ $event->category }}" required>
                            <option value="" selected>選択してください</option>
                            @foreach (config('categorys') as $key => $category)
                            <option value="{{ $key }}"
                            @if($event->category == $key)
                                selected="selected"
                            @endif
                            >{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="content" class="col-md-3 col-form-label">内容</label>
                        <textarea id="content" class="col-md-12 form-control @error('content') is-invalid @enderror" name="content" style="height:600px;" required>{{ html_entity_decode($event->content) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="capacity" class="col-md-3 col-form-label">定員</label>
                        <input id="capacity" class="col-md-3 form-control @error('capacity') is-invalid @enderror" type="text" name="capacity" value="{{ $event->capacity }}" required>
                    </div>
                    <div class="form-group">
                        <label for="start" class="col-md-3 col-form-label">開催期間</label>
                        <input id="start" class="col-md-3 form-control @error('start') is-invalid @enderror" type="text" name="start" value="{{ $event->start }}" required>
                        　～　
                        <input id="end" class="col-md-3 form-control @error('end') is-invalid @enderror" type="text" name="end" value="{{ $event->end }}" required>
                    </div>
                    <div class="form-group text-center">
                        <input type="submit" class="btn btn-primary " value="イベントを編集する">
                    </div>
                    <input type="hidden" name="event_id" value="{{ $event->id }}">
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
