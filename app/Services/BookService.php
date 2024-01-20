<?php

namespace App\Services;

use App\Models\Book;
use Illuminate\Support\Facades\Log;

class BookService
{
    public function getBooks(
        string $order_by = Book::DEFAULT_SORT_ATTR,
        string $how = Book::DEFAULT_SORT,
        array $filter = []
    ): \Illuminate\Database\Eloquent\Collection|array
    {
        $query = Book::query();

        if ($filter) {
            foreach ($filter as $key => $value) {
                if ($value) {
                    if (in_array($key, Book::FILTERABLE_INT_ATTRS)) {
                        $query->where($key, '=', $value);
                    } else {
                        $query->where($key, '%like%', $value);
                    }
                }
            }
        }

        return $query->orderBy($order_by, $how)->get();
    }

    public function create(array $params): bool
    {
        try {
            $book = new Book();
            $book->title = $params['title'];
            $book->genre = $params['genre'];
            $book->save();

            $book->authors()->attach($params['authors']);
            return true;
        } catch (\Throwable $e) {
            Log::error($e->getMessage() . ' ' . $e->getFile() . ' ' . $e->getLine());
            return false;
        }
    }

    public function update(array $params, Book $book): bool
    {
        try {
            $book->update(['title' => $params['title']]);
            $book->update(['genre' => $params['genre']]);
            $book->authors()->sync($params['authors']);
            return true;
        } catch (\Throwable $e) {
            Log::error($e->getMessage() . ' ' . $e->getFile() . ' ' .  $e->getLine());
            return false;
        }
    }

    public function delete(Book $book)
    {
        try {
            $book->delete();
            return true;
        } catch (\Throwable $e) {
            Log::error($e->getMessage() . ' ' . $e->getFile() . ' ' .  $e->getLine());
            return false;
        }
    }

    public function getSpecials()
    {
        return Book::whereHas('authors', function($query) {
            $query->groupBy('book_id')->havingRaw('Count(*) >= 3');
        })->get();
    }
}
