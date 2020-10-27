@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">プロフィール設定<a class="btn btn-sm btn-outline-secondary float-right" href="{{ url('home/edit_password') }}">パスワード変更</a></div>
                @include('layouts.alert')
                <div class="card-body">
                    <form method="POST" action="{{ action('HomeController@edit_post') }}" onSubmit="return dialog('プロフィールを更新しますか？')">
                        @csrf
                        <div class="form-group row">
                            <label for="nickname" class="col-md-3 col-form-label">ニックネーム</label>
                            <input id="nickname" type="text" class="col-md-8 form-control @error('nickname') is-invalid @enderror" name="nickname" value="{{ Auth::user()->nickname }}" required>
                            @error('nickname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-3 col-form-label">氏名</label>
                            <input id="name" type="text" class="col-md-8 form-control @error('name') is-invalid @enderror" name="name" value="{{ Auth::user()->name }}" required>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-md-3 col-form-label">メールアドレス</label>
                            <input id="email" type="email" class="col-md-8 form-control @error('email') is-invalid @enderror" name="email" value="{{ Auth::user()->email }}" required>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group row">
                            <label for="work" class="col-md-3 col-form-label">職業</label>
                            <input id="work" type="text" class="col-md-8 form-control @error('work') is-invalid @enderror" name="work" value="{{ Auth::user()->work }}" required>
                        </div>
                        <div class="form-group row">
                            <label for="sex" class="col-md-3 col-form-label">性別</label>
                            <span class="col-md-8 my-auto text-secondary">@if( Auth::user()->sex == 1)男性@else女性@endif</span>
                        </div>
                        <div class="form-group row">
                            <label for="prefecture" class="col-md-3 col-form-label">お住まいの地域</label>
                            <select id="prefecture" class="col-md-4 form-control @error('prefecture') is-invalid @enderror" name="prefecture" value="{{ old('prefecture') }}" required>
                            @foreach (config('prefs') as $key => $pref)
                            <option value="{{ $key }}"
                                @if ($key == Auth::user()->prefecture )
                                    selected="selected"
                                @endif
                            >{{ $pref }}</option>
                            @endforeach
                            </select>
                            <input id="city" type="text" class="col-md-4 form-control @error('city') is-invalid @enderror" name="city" value="{{ Auth::user()->city }}" placeholder="(例)名古屋市" required>
                        </div>
                        <div class="form-group text-center">
                            <input type="submit" class="btn btn-primary " value="プロフィール更新">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
