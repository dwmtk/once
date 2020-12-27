@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">エラー</div>
                <div class="card-body">
                    <div class="alert alert-danger mt-2">
                    @if(isset($message))
                        {{ $message }}
                    @else
                        エラーが発生しました。
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
