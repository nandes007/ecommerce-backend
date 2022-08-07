<?php

namespace App\Listeners;

use App\Events\RegisteredUser;
use App\Mail\RegisteredUser as MailRegisteredUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendEmailVerificationCode
{
    public $afterCommit = true;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\RegisteredUser  $event
     * @return void
     */
    public function handle(RegisteredUser $event)
    {
        Mail::to($event->user->email)->send(new MailRegisteredUser($event->user->code));
    }
}
