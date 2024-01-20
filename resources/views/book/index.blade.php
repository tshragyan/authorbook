@extends('layouts.layout')
@section('content')
    <div class="mb-4">
        @foreach($sorts as $key => $val)
            <a style="margin:10px" href=
                @if (Request::get('how') &&  Request::get('how')=='asc' ||  !Request::get('how'))
                    "{{ route('book.index',['order_by' => $key, 'how' => 'desc'])  }}"
            @elseif (Request::get('how') &&  Request::get('how')=='desc')
                "{{ route('book.index',['order_by' => $key, 'how' => 'asc'])  }}"
            @endif
            >{{$val}}
            </a>
    </div>


    @endforeach()
    <div class="mb-4">
        <h2>Filter</h2>
        <form  action="{{ route('book.index') }}" method="get">
            @csrf
            <input type="number" name="filter[id]" placeholder="id" class="form-control">
            <input type="text" name="filter[title]" placeholder="title" class="form-control">
            <input type="text" name="filter[genre]" placeholder="genre" class="form-control">
            <button type="submit" class="btn btn-success">Search</button>
        </form>
    </div>
    <table class="table table-bordered">
        <tr>
            <td>id</td>
            <td>title</td>
            <td>genre</td>
            <td>remove</td>
            <td>change</td>
        </tr>
        @if(!empty($books))
            @foreach($books as $book)
                <tr>
                    <td>
                        {{ $book->id }}
                    </td>
                    <td>
                        <a href="{{ route('book.show',['book' => $book]) }}">{{ $book->title }}</a>
                    </td>
                    <td>
                        {{ $book->genre }}
                    </td>
                    <td>
                        <form action="{{ route('book.destroy',['book' =>$book]) }}" method="post">
                            @csrf
                            @method('delete')
                            <button class="btn btn-danger" type="submit">remove</button>
                        </form>
                    </td>
                    <td>
                        <button class="btn btn-danger"><a style="color:black" href="{{ route('book.edit',['book' =>$book])}}">Edit</a>
                    </td>
                </tr>
            @endforeach
    </table>
    @endif
    <button class="btn btn-success"><a href="{{ route('book.create') }}">Add Book</a></button>
    @if(Session::has('message'))
        <p class="text-success">{{ Session::get('message') }}</p>
    @endif
    @if(Session::has('error'))
        <p class="text-success">{{ Session::get('message') }}</p>
    @endif
@endsection
