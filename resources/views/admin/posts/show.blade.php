@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            @if (session('status'))
                <div class="alert alert-danger">
                    {{ session('status') }}
                </div>
            @endif
        </div>

        <div class="row">
            <div class="col">
                <h1>
                    {{ $post->title }}
                </h1>
                <h2>Category: {{ $post->category()->first()->name }} </h2>
                <h3>Author: {{ $post->user()->first()->name }} </h3>
            </div>
        </div>
        <div class="row">
            <div class="col">
                {{ $post->content }}
            </div>
            <div class="col">
                <img class="img-fluid" src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}">
            </div>
        </div>
    </div>
@endsection
