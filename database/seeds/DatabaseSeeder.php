<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();
        $path = 'database/dbdata/testdata.sql';
        DB::unprepared(file_get_contents($path));
        $this->command->info('Db seeded!');
    }
}
