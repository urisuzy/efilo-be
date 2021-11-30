<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'efilo:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $create = User::updateOrCreate([
            'name' => 'admin',
            'email' => 'admin',
            'role' => 'admin'
        ], [
            'password' => bcrypt('12345678')
        ]);

        echo 'Admin Created ' . PHP_EOL;
        echo 'Username: admin' . PHP_EOL;
        echo 'Password: 12345678';
    }
}
