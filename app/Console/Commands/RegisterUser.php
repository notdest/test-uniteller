<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Exception;
use Illuminate\Support\Facades\DB;

class RegisterUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:register {name} {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Добавляет пользователя с указанными name email password';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $params = [
            'name'      => $this->argument('name'),
            'email'     => $this->argument('email'),
            'password'  => $this->argument('password'),
        ];

        $validator  = Validator::make($params, [
                'name'      => ['required', 'string', 'max:255'],
                'email'     => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
                'password'  => ['required', 'string', 'max:255'],
        ]);

        if($validator->fails()){
            $errors = $validator->errors()->all();
            foreach ($errors as $error) {
                echo $error."\n";
            }
            return Command::FAILURE;
        }

        DB::transaction(function () use($params){
            $user = User::create($params);
            DB::insert('INSERT INTO `balances` (`user_id`, `balance`) VALUES (?, 0);', [$user->id]);
        });


        echo "User ".$params['name']." created\n";
        return Command::SUCCESS;
    }
}
