@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">イベント詳細・編集画面　
                    <a class="btn btn-sm btn-outline-secondary float-right ml-1" href="{{ url('manage/index') }}">戻る</a>
                    <a class="btn btn-sm btn-outline-secondary float-right" href="{{ action('EventController@detail', $event->id) }}" target="_blank">詳細画面</a>
                    <a href="{{ action('ManageController@stop', $event->id) }}" class="btn btn-warning btn-sm disabled">募集を打ち切る※未実装</a>
                </div>
                @include('layouts.alert')
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

                <h5 class="mt-4">イベント詳細・編集</h5>
                <form method="POST" action="{{ url('manage/update') }}" class="col-md-12" enctype="multipart/form-data" onSubmit="return dialog('イベントを編集してよろしいですか？')">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="col-md-3 col-form-label">イベント名<span class="badge badge-danger ml-1">必須</span></label>
                        <input id="name" type="text" class="col-md-12 form-control @error('name') is-invalid @enderror" name="name" value="{{ $event->name }}" required>
                    </div>
                    <div class="form-group">
                        <label for="category" class="col-md-3 col-form-label">カテゴリ<span class="badge badge-danger ml-1">必須</span></label>
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
                        <label for="content" class="col-md-5 col-form-label">内容（HTMLコードの記述も可能）<span class="badge badge-danger ml-1">必須</span><br><small>※注意：スマホの絵文字利用不可</small></label>
                        <textarea id="content" class="col-md-12 form-control @error('content') is-invalid @enderror" name="content" style="height:600px;" required>{{ html_entity_decode($event->content) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="capacity" class="col-md-3 col-form-label">定員<span class="badge badge-danger ml-1">必須</span></label>
                        <div class="form-inline">
                            <input id="capacity" class="col-5 form-control @error('capacity') is-invalid @enderror" type="text" name="capacity" value="{{ $event->capacity }}" required>
                            <label for="capacity" class="col-form-label mx-1">人</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="fee" class="col-md-3 col-form-label">参加費<span class="badge badge-danger ml-1">必須</span></label>
                        <div class="form-inline">
                            <input id="fee" class="col-5 form-control @error('fee') is-invalid @enderror" type="text" name="fee" value="{{ $event->fee }}" required>
                            <label for="fee" class="col-form-label mx-1">円</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="place" class="col-md-3 col-form-label">開催場所<span class="badge badge-danger ml-1">必須</span></label>
                        <input id="place" class="col-md-3 form-control @error('place') is-invalid @enderror" type="text" name="place" value="{{ $event->place }}" required>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-form-label">開催期間<span class="badge badge-danger ml-1">必須</span></label>
                        <div class="form-inline">
                            <input id="start_y" class="col-3 form-control form-control-sm @error('start_y') is-invalid @enderror" type="text" name="start_y" value="{{ substr($event->start, 0, 4) }}" required><label for="start_y" class="col-form-label mx-1">年</label>
                            <input id="start_m" class="col-2 form-control form-control-sm @error('start_m') is-invalid @enderror" type="text" name="start_m" value="{{ substr($event->start, 4, 2) }}" required><label for="start_m" class="col-form-label mx-1">月</label>
                            <input id="start_d" class="col-2 form-control form-control-sm @error('start_d') is-invalid @enderror" type="text" name="start_d" value="{{ substr($event->start, 6, 2) }}" required><label for="start_d" class="col-form-label mx-1">日</label>
                        </div>
                        <div class="form-inline">
                            <input id="start_hour" class="col-2 form-control form-control-sm @error('start_hour') is-invalid @enderror" type="text" name="start_hour" value="{{ substr($event->start, 8, 2) }}" required><label for="start_hour" class="col-form-label mx-1">時</label>
                            <input id="start_min" class="col-2 form-control form-control-sm @error('start_min') is-invalid @enderror" type="text" name="start_min" value="{{ substr($event->start, 10, 2) }}" required><label for="start_min" class="col-form-label mx-1">分</label>
                        </div>
                        　～　
                        <div class="form-inline">
                            <input id="end_y" class="col-3 form-control form-control-sm @error('end_y') is-invalid @enderror" type="text" name="end_y" value="{{ substr($event->end, 0, 4) }}" required><label for="end_y" class="col-form-label mx-1">年</label>
                            <input id="end_m" class="col-2 form-control form-control-sm @error('end_m') is-invalid @enderror" type="text" name="end_m" value="{{ substr($event->end, 4, 2) }}" required><label for="end_m" class="col-form-label mx-1">月</label>
                            <input id="end_d" class="col-2 form-control form-control-sm @error('end_d') is-invalid @enderror" type="text" name="end_d" value="{{ substr($event->end, 6, 2) }}" required><label for="end_d" class="col-form-label mx-1">日</label>
                        </div>
                        <div class="form-inline">
                            <input id="end_hour" class="col-2 form-control form-control-sm @error('end_hour') is-invalid @enderror" type="text" name="end_hour" value="{{ substr($event->end, 8, 2) }}" required><label for="end_hour" class="col-form-label mx-1">時</label>
                            <input id="end_min" class="col-2 form-control form-control-sm @error('end_min') is-invalid @enderror" type="text" name="end_min" value="{{ substr($event->end, 10, 2) }}" required><label for="end_min" class="col-form-label mx-1">分</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="image1" class="col-md-3 col-form-label">画像 ※1枚のみ<span class="badge badge-secondary ml-1">任意</span></label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" id="image1" name="image1" class="custom-file-input">
                                <label class="custom-file-label" for="image1" data-browse="参照">ファイルを選択</label>
                            </div>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-outline-secondary input-group-text reset">取消</button>
                            </div>
                        </div>
                        @if(!empty($event->image))
                            <div class="text-center mt-2" style="width:100%;">
                                <img src="/storage/event/{{ $event->id }}/{{ $event->image }}" style="width:100%;">
                            </div>
                        @endif
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
