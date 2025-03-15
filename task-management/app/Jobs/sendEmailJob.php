<?php

namespace App\Jobs;

use App\Mail\TaskMail;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
class sendEmailJob implements ShouldQueue
{

    use Queueable;
    public $email;
    public $user;
    public $task;
    /**
     * Create a new job instance.
     */
    public function __construct($email,$user,$task)
    {
        //
        $this->email = $email;
        $this->user = $user;
        $this->task = $task;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try
        {
            Mail::to($this->email)->send(new TaskMail($this->user,$this->task));
            Log::info("email send ");
        }
        catch(Exception $e)
        {
            Log::error('Email sending failed', ['error' => $e->getMessage()]);
        }

        //
    }
}
