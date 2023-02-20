<?php

namespace App\Console\Commands;

use App\Mail\UserRegistered;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class Email extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Email testing';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $userFrom = User::where('email', 'jawadmaqbool3@gmail.com')->first();
        $userTo = User::where('email', 'jawadmaqbool3@gmail.com')->first();
        Mail::to($userFrom)->send(new UserRegistered($userTo));
        return Command::SUCCESS;
    }
}
