<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewEvent extends Mailable
{
    use Queueable, SerializesModels;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($event, $user)
    {
        $this->event = $event;
        $this->owner = $user;
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
        $subject = $this->event->name;
        return $this->view('emails.NewEvent')
            ->with('event', $this->event)
            ->with('owner', $this->owner)
            ->from($address, $name)
            ->replyTo($address, $name)
            ->subject($subject);
    }


}
