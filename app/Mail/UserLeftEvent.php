<?php

namespace App\Mail;

use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserLeftEvent extends Mailable
{
    use Queueable, SerializesModels;

    public $event;
    public $user;

    public function __construct(Event $event, $user)
    {
        $this->event = $event;
        $this->user = $user;
    }

    public function build()
    {
        return $this->markdown('emails.user_left_event')
            ->subject('A user has left ' . $this->event->title  . '.')
            ->with(['event' => $this->event, 'user' => $this->user]);
    }
}
