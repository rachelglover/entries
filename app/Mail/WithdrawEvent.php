<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class WithdrawEvent extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $event, $entries)
    {
        //
        $this->event = $event;
        $this->athlete = $user;
        $this->entry = $entries;
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
        return $this->view('emails.WithdrawEvent')
            ->with('athlete', $this->athlete)
            ->with('entries', $this->entry)
            ->with('event', $this->event)
            ->from($address, $name)
            ->replyTo($address, $name)
            ->subject($subject);
    }
}
