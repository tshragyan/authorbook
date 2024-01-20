<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $title
 * @property string $genre
 * @property Author[] $authors
 */
class Book extends Model
{
    use HasFactory;

    const SORTABLE_ATTRS = [
        'id' => 'id',
        'title'=>'title',
        'genre' => 'genre'
    ];

    const FILTERABLE_ATTRS = [
        'id',
        'title',
        'genre'
    ];

    const FILTERABLE_INT_ATTRS = [
        'id'
    ];

    const FILTERABLE_STRING_ATTRS = [
        'title',
        'genre'
    ];

    const DEFAULT_SORT_ATTR = 'id';

    const DEFAULT_SORT = 'asc';

    protected $fillable = ['title'];

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class, AuthorBook::class, 'book_id', 'author_id');
    }

}
