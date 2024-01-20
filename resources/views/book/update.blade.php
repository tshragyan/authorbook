@extends('layouts.layout')
@section('content')
    <h1 align="center"> change Book</h1>
    <form action="{{ route('book.update',['book' => $book]) }}" method="post">
        @csrf
        @method('put')
        <input type="text" name="title" placeholder="title" value="{{ $book->title }}" class=" title form-control">
        @if ($errors->has('title'))
            <p class="text-danger">{{ $errors->first('title') }}</p>
        @endif

        <input type="text" name="genre" placeholder="Gener" class="form-control" value="{{$book->genre}}">
        @if ($errors->has('genre'))
            <p class="text-danger">{{ $errors->first('genre') }}</p>
        @endif
        <select name="authors[]" id="" class="authors form-control" multiple="multiple">
            @foreach($authors as $author)
                <option value="{{ $author->id }}"
                        @if(array_key_exists($author->name, $belongs))
                            selected="selected"
                    @endif
                >{{ $author->name }}</option>
            @endforeach
        </select>
        @if ($errors->has('authors'))
            <p class="text-danger">{{ $errors->first('authors') }}</p>
        @endif

        <button class="btn btn-success cons" type="submit">Change Book</button>
    </form>
    @if(Session::has('message'))
        <p class="text-success">{{ Session::get('message') }}</p>
    @endif
    @if(Session::has('error'))
        <p class="text-danger">{{ Session::get('error') }}</p>
    @endif
    <script src="{{ asset('js/index.js') }}"></script>

@endsection
