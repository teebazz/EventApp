<?php

namespace App\Traits;

use App\Mail\InviteMail;
use Illuminate\Support\Facades\Mail;

trait MessageTrait
{
    public function sendMail($attendee)
    {
        // Send mail initemail mailable
        Mail::to($attendee->email)->send(new InviteMail($attendee));
    }
}