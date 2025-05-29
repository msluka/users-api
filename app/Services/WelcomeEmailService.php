<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Mail;

class WelcomeEmailService
{
    public function send(User $user): void
    {
        $emails = $user->emails()->pluck('email')->toArray();

        $message = $this->buildMessage($user);

        Mail::raw($message, function ($mail) use ($emails) {
            $mail->to($emails)
                 ->subject('Welcome!');
        });
    }

    public function buildMessage(User $user): string
    {
        return "Welcome {$user->firstname} {$user->lastname}!";
    }
}
