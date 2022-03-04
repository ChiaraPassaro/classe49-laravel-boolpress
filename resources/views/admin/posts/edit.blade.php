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
                    Modify {{ $post->title }}
                </h1>
            </div>
        </div>
        <div class="row">
            <form action="{{ route('admin.posts.update', $post) }}" method="post">
                @csrf
                @method('PATCH')
                <div class="mb-3">
                    <select class="form-select" name="category_id">
                        {{-- se la categoria scelta dall'utente precedentemente e' 
                        identica a quella su cui sto girando inserisco
                        l'attributo selected --}}
                        <option value="">Select a category</option>
                        @foreach ($categories as $category)
                            {{-- <option {{ old('category_id') == $category->id ? 'selected' : '' }}
                                value="{{ $category->id }}"> --}}
                            <option @if (old('category_id', $post->category_id) == $category->id) selected @endif value="{{ $category->id }}">
                                {{ $category->name }} - {{ $category->id }}</option>
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
                    {{-- se abbiamo gia compilato il form e siamo tornati indietro per validazione errata allora facciamo un foreach e controlliamo old('tags') --}}
                    @if ($errors->any())
                        @foreach ($tags as $tag)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="{{ $tag->id }}" name="tags[]"
                                    {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="flexCheckDefault">
                                    {{ $tag->name }}
                                </label>
                            </div>
                        @endforeach
                    @else
                        {{-- Altrimenti prendiamo i dati dal db e checchiamo i nostri checkbox corrispondenti --}}
                        @foreach ($tags as $tag)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="{{ $tag->id }}" name="tags[]"
                                    {{ $post->tags()->get()->contains($tag->id)? 'checked': '' }}>
                                <label class="form-check-label" for="flexCheckDefault">
                                    {{ $tag->name }}
                                </label>
                            </div>
                        @endforeach
                    @endif
                </fieldset>
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title"
                        value=" {{ old('title', $post->title) }}">
                    @error('title')
                        <div class="alert alert-danger mt-3">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">Content</label>
                    <textarea class="form-control" id="content" rows="3"
                        name="content"> {{ old('content', $post->content) }}</textarea>
                    @error('content')
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
