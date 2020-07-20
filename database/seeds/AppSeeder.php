<?php

use Illuminate\Database\Seeder;
use App\Model\Admin;
use App\Model\Stream;

class AppSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Seeding Required Data');
        Admin::create([
            'name' => 'Admin',
            'email' => 'admin@app.com',
            'password' => bcrypt('password'),
            'code' =>'password',
        ]);
        
        $stream = ['Arts','Science','Commerce','No Stream'];
        for ($i=0; $i <4 ; $i++) { 
            Stream::create([
                'name' => $stream[$i],
            ]);
        }
        $this->command->info('Seeding Completed');
    }
}
