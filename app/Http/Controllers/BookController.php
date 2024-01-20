<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBookRequest;
use App\Models\Author;
use App\Models\Book;
use App\Rules\FilterRule;
use App\Rules\SortRule;
use App\Rules\SortHowRule;
use App\Services\BookService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    public function index(Request $request, BookService $bookService): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $validator = Validator::make($request->all(), [
            'order_by' => ['nullable', 'string', new SortRule(array_keys(Book::SORTABLE_ATTRS))],
            'filter' => ['nullable', 'array', new FilterRule(Book::FILTERABLE_ATTRS)],
            'how' => ['nullable', 'string', new SortHowRule(['asc', 'desc'])]
        ]);

        $validator->validate();
        $validated = $validator->validated();
        $books = $bookService->getBooks(...$validated);

        return view('book.index', ['books' => $books, 'sorts' => Book::SORTABLE_ATTRS]);
    }

    public function create(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $authors = Author::all();
        return view('book.create', ['authors' => $authors]);
    }

    public function store(CreateBookRequest $request, BookService $bookService): \Illuminate\Http\RedirectResponse
    {
        $response = $bookService->create($request->validated());

        if ($response) {
            Session::flash('message', 'book Added');
            return redirect()->route('book.index');
        }

        Session::flash('error', 'something went wrong');
        return  redirect()->back();
    }

    public function show(Book $book): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $authors = $book->authors->pluck('id', 'name')->toArray();
        return view('book.show', ['book' => $book, 'authors' => $authors]);
    }

    public function edit(Book $book)
    {
        $authors = Author::all();
        $belongauthors = $book->authors->pluck('id', 'name')->toArray();
        return view('book.update', ['book' => $book, 'authors' => $authors, 'belongs' => $belongauthors]);
    }

    public function update(CreateBookRequest $request, Book $book, BookService $bookService)
    {
        $response  = $bookService->update($request->validated(), $book);

        if ($response) {
            Session::flash('message', 'book changed');
            return redirect()->route('book.edit',['book' => $book]);
        } else {
            Session::flash('error', 'something went wrong');
            return redirect()->route('book.edit',['book' => $book]);
        }

    }

    public function destroy(Book $book, BookService $bookService)
    {
        $response = $bookService->delete($book);

        if ($response) {
            Session::flash('message', 'book changed');
            return redirect()->back();
        } else {
            Session::flash('error', 'something went wrong');
            return redirect()->back();
        }
    }

    public function special(BookService $bookService)
    {
        $specials = $bookService->getSpecials();

        return view('book.specials', ['books' => $specials]);
    }
}
