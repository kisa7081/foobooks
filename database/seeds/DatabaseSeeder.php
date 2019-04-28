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
         $this->call(BooksTableSeeder::class);
    }
}
