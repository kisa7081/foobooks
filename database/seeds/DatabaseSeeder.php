<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     *
     * php artisan db:seed
     * or
     * php artisan migrate:fresh --seed
     *
     * c6650ab736e2948cf52fd7106582310e39ad9e3419332690
     */
    public function run()
    {
        # Because `books` will be associated with `authors`,
        # authors should be seeded first
        $this->call(AuthorsTableSeeder::class);
        $this->call(BooksTableSeeder::class);
        $this->call(TagsTableSeeder::class);
        $this->call(BookTagTableSeeder::class);
    }
}
