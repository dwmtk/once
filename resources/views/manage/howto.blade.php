@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">管理者ページの使い方<a class="btn btn-sm btn-outline-secondary float-right" href="{{ url('manage/index') }}">戻る</a></div>
                @include('layouts.alert')
                <div class="card-body">
                    <div class="">
                    <legend>イベントの新規作成</legend>
                    <p>
                        １．管理者ページより、「新規作成」ボタンを押下<br>
                        ２．新規作成ページより、イベントの各種情報を入力<br>
                        ３．「イベントを新規作成」ボタンを押下
                    </p>
                    </div>
                    <div>
                    <hr>
                    <legend>イベントの編集</legend>
                    <p>
                        １．管理者ページより、編集したいイベントを押下<br>
                        ２．イベント詳細・編集ページのイベント詳細・編集欄より、イベントの各種情報を編集<br>
                        <small>「詳細画面」ボタンを押下すると、イベント詳細ページを閲覧可能</small><br>
                        ３．「イベントを編集する」ボタンを押下
                    </p>
                    </div>
                    <hr>
                    <div>
                    <legend>イベント参加者一覧</legend>
                    <p>
                        １．管理者ページより、編集したいイベントを押下<br>
                        ２．イベント詳細・編集ページの参加者一覧欄より、イベント参加者の一覧を閲覧可能<br>
                        <small>「詳細画面」ボタンを押下すると、イベント詳細ページを閲覧可能</small>
                    </p>
                    </div>
                    <hr>
                    <div>
                    <legend>利用者一覧（Webサイト登録者）</legend>
                    <p>
                        １．管理者ページより、「利用者一覧」を押下<br>
                        ２．利用者一覧ページより、利用者一覧を閲覧可能
                    </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
