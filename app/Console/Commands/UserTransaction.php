<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UserTransaction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:transaction {email} {amount} {message}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Операции с балансом пользователя - по email, сумме с знаком и сообщению';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $email      = $this->argument('email');
        $amount     = $this->argument('amount');
        $message    = $this->argument('message');

        \App\Jobs\transaction::dispatch($email,$amount,$message);

        return Command::SUCCESS;
    }
}
