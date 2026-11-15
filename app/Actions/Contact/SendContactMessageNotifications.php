<?php

namespace App\Actions\Contact;

use App\Mail\Contact\ContactAutoReply;
use App\Mail\Contact\NewContactMessageReceived;
use App\Models\ContactMessage;
use App\Models\Setting;
use Closure;
use Illuminate\Support\Facades\Mail;
use Throwable;

class SendContactMessageNotifications
{
    /**
     * Email the office and the sender about a new contact message.
     */
    public function handle(ContactMessage $contactMessage): void
    {
        $this->send(fn () => Mail::to(Setting::officeEmail())->send(new NewContactMessageReceived($contactMessage)));
        $this->send(fn () => Mail::to($contactMessage->email)->send(new ContactAutoReply($contactMessage)));
    }

    /**
     * Deliver a notification without failing the message already persisted.
     */
    private function send(Closure $callback): void
    {
        try {
            $callback();
        } catch (Throwable $exception) {
            report($exception);
        }
    }
}
