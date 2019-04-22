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
     */
    public function run()
    {
         $this->call(BooksTableSeeder::class);
    }
}
