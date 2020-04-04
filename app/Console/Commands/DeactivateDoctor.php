<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

use App\User;
use App\Doctor;

class DeactivateDoctor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'doctor:deactivate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deactivate doctor';

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
     * @return mixed
     */
    public function handle()
    {
        $users = User::with('session')->whereHas('groups', function($query) {
            $query->where('name', 'doctor');
        })->get();
        foreach ($users as $user) {
            if ($user->session) {
                $lastActivity = Carbon::parse($user->session->last_activity);
                $diff = Carbon::now()->diffInMinutes($lastActivity);
                if ($diff >= config('session.lifetime')) {
                    Doctor::where('user_id', $user->id)->update(['status' => 'nonactive']);
                }
            }
        }
    }
}
