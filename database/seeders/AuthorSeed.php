<?php

namespace Database\Seeders;

use App\Models\Author;
use Faker\Factory;
use Illuminate\Database\Seeder;

class AuthorSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Author::all()->isEmpty()) {

            for ($i = 0; $i < 20 ; $i++) {
                $author = new Author();
                $author->name = (Factory::create())->name();
                $author->save();
            }

        }
    }
}
