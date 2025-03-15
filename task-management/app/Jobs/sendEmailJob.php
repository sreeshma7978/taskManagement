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

    /**
     * Create a new job instance.
     */
    public function __construct($email)
    {
        //
        $this->email = $email;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try
        {
            Mail::to($this->email)->send(new TaskMail());
            Log::error("email send ");
        }
        catch(Exception $e)
        {
            Log::error('Email sending failed', ['error' => $e->getMessage()]);
        }

        //
    }
}
