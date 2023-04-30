<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use PHPUnit\Exception;

class transaction implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 1;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        private string $email,
        private float  $amount,
        private string $message,
    )
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $user = User::where(['email' => $this->email])->firstOrFail();

        try{
            DB::beginTransaction();

            $balance    = DB::scalar("SELECT `balance` FROM `balances` WHERE `user_id` = ? ;", [$user->id] );

            if($balance < -$this->amount){
                throw new \Exception("Недостаточно средств");
            }

            DB::update("UPDATE `balances` SET `balance`=`balance`+ ? WHERE `user_id` = ?;", [$this->amount,$user->id]);

            DB::insert("INSERT INTO `operations` (`user_id`, `amount`, `message`) VALUES (?, ?, ?);",
                                                                            [$user->id,$this->amount,$this->message]);

            DB::commit();
        }catch (Exception $e){
            DB::rollBack();
            throw $e;
        }
    }
}
