<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:admin {email} {--name=} {--password=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create or update an admin user';

    public function handle()
    {
        $email = $this->argument('email');
        $name = $this->option('name') ?: 'Admin';
        $password = $this->option('password') ?: bin2hex(random_bytes(4));

        $user = User::where('email', $email)->first();
        if (! $user) {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'role' => 'admin',
            ]);
            $this->info("Admin user created: {$email}");
        } else {
            $user->name = $name;
            $user->password = Hash::make($password);
            $user->role = 'admin';
            $user->save();
            $this->info("Admin user updated: {$email}");
        }

        $this->line("Password: {$password}");
        return 0;
    }
}
