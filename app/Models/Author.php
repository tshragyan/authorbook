<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $name
 * @property Book[] $book
 */
class Author extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function books(): BelongsToMany
    {
       return $this->belongsToMany(Book::class, AuthorBook::class, 'author_id', 'book_id');
    }
}
