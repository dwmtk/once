@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">新規作成</div>
                <div class="card-body">
                    <form method="POST" action="{{ url('manage/insert') }}" class="col-md-12">
                    @csrf
                        <div class="form-group">
                            <label for="name" class="col-md-3 col-form-label">イベント名</label>
                            <input id="name" type="text" class="col-md-12 form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="category" class="col-md-3 col-form-label">カテゴリ</label>
                            <select id="category" class="col-md-12 form-control @error('category') is-invalid @enderror" type="text" name="category" value="{{ old('category') }}" required>
                                <option value="" selected>選択してください</option>
                                @foreach (config('categorys') as $key => $category)
                                <option value="{{ $key }}">{{ $category }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="content" class="col-md-3 col-form-label">内容</label>
                            <textarea id="content" class="col-md-12 form-control @error('content') is-invalid @enderror" name="content" style="height:600px;" required>{{ old('content') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="capacity" class="col-md-3 col-form-label">定員</label>
                            <input id="capacity" class="col-md-3 form-control @error('capacity') is-invalid @enderror" type="text" name="capacity" value="{{ old('capacity') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="start" class="col-md-3 col-form-label">開催期間</label>
                            <input id="start" class="col-md-3 form-control @error('start') is-invalid @enderror" type="text" name="start" value="{{ old('start') }}" required>
                            　～　
                            <input id="end" class="col-md-3 form-control @error('end') is-invalid @enderror" type="text" name="end" value="{{ old('end') }}" required>
                        </div>
                        <div class="form-group text-center">
                            <input type="submit" class="btn btn-primary " value="イベントを新規作成">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
