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
                    Create New Posts
                </h1>
            </div>
        </div>
        <div class="row">
            <form action="{{ route('admin.posts.store') }}" method="post">
                @csrf
                @method('POST')
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" value=" {{ old('title') }}">
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">Content</label>
                    <textarea class="form-control" id="content" rows="3" name="content"> {{ old('content') }}</textarea>
                </div>

                {{-- <input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id }}"> --}}

                <input class="btn btn-primary" type="submit" value="Save">
            </form>
        </div>
    </div>
@endsection
