<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'              => 'Admin',
            'email'             => 'admin@app.com',
            'password'          => bcrypt('password'),
            'is_admin'          => true,
            'email_verified_at' => now(),
            'remember_token'    => Str::random(10),
        ]);
        User::factory(20)->create();
        Product::factory(100)->create();

        $this->command->info('Seeded: 21 users and 100 products.');
    }
}
