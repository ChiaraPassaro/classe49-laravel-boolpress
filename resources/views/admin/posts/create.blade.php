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
            <form action="{{ route('admin.posts.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="mb-3">
                    <select class="form-select" name="category_id">
                        {{-- se la categoria scelta dall'utente precedentemente e' 
                        identica a quella su cui sto girando inserisco
                        l'attributo selected --}}
                        <option value="">Select a category</option>
                        @foreach ($categories as $category)
                            {{-- <option {{ old('category_id') == $category->id ? 'selected' : '' }}
                                value="{{ $category->id }}"> --}}
                            <option @if (old('category_id') == $category->id) selected @endif value="{{ $category->id }}">
                                {{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="alert alert-danger mt-3">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                @error('tags.*')
                    <div class="alert alert-danger mt-3">
                        {{ $message }}
                    </div>
                @enderror
                <fieldset class="mb-3">
                    <legend>Tags</legend>
                    @foreach ($tags as $tag)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="{{ $tag->id }}" name="tags[]"
                                {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="flexCheckDefault">
                                {{ $tag->name }}
                            </label>
                        </div>
                    @endforeach
                </fieldset>

                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" value=" {{ old('title') }}">
                    @error('title')
                        <div class="alert alert-danger mt-3">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">Content</label>
                    <textarea class="form-control" id="content" rows="3"
                        name="content"> {{ old('content') }}</textarea>
                    @error('content')
                        <div class="alert alert-danger mt-3">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="title" class="form-label">Created</label>
                    <input type="date" class="form-control" id="created_at" name="created_at"
                        value=" {{ old('created_at') }}">
                    @error('created_at')
                        <div class="alert alert-danger mt-3">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- image upload --}}
                <div class="mb-3">
                    @dd(old('image'))
                    <label for="image" class="form-label">Image</label>
                    <input class="form-control" type="file" id="image" name="image">
                    @error('image')
                        <div class="alert alert-danger mt-3">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                {{-- <input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id }}"> --}}

                <input class="btn btn-primary" type="submit" value="Save">
            </form>
        </div>
    </div>
@endsection
