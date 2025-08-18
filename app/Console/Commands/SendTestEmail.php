<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendTestEmail extends Command
{
    protected $signature = 'send:test-email';
    protected $description = 'Send a test email to verify email configuration';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        Mail::raw('This is a test email.', function ($message) {
            $message->to('meliagriselda5@gmail.com')->subject('Test Email');
        });

        $this->info('Test email sent successfully!');
    }
}
