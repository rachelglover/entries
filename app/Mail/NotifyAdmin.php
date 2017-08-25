<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyAdmin extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     * $type = 'refund', 'new_event', 'new_entry', 'event_published'
     *
     * @return void
     */
    public function __construct($type, $event, $message)
    {
        $this->type = $type;
        $this->event = $event;
        $this->messagetext = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address = 'contact@foresightentries.com';
        $name = "Foresight Entries";
        $subject = "ADMIN NOTIFICATION: " . $this->event->name;
        return $this->view('emails.NotifyAdmin')
            ->with('type', $this->type)
            ->with('messagetext', $this->messagetext)
            ->with('event', $this->event)
            ->from($address, $name)
            ->replyTo($address, $name)
            ->subject($subject);
    }
}
