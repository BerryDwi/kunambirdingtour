<?php

namespace App\Actions\Contact;

use App\Http\Requests\StoreContactRequest;
use App\Models\ContactMessage;

class StoreContactMessage
{
    /**
     * Persist a message submitted through the public contact form.
     */
    public function handle(StoreContactRequest $request): ContactMessage
    {
        $data = $request->validated();

        unset($data['website']);

        return ContactMessage::create([
            ...$data,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
    }
}
