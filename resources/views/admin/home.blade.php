@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
        </div>
        <div class="row">
            <div class="col">
                <h1>
                    Welcome {{ Auth::user()->name }} - {{ Auth::user()->userInfo()->first()->phone }}
                </h1>
            </div>
        </div>
    </div>
@endsection
