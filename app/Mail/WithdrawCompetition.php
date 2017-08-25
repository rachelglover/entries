<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class WithdrawCompetition extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $entry, $competition, $event)
    {
        //
        $this->athlete = $user;
        $this->entry = $entry;
        $this->competition = $competition;
        $this->event = $event;
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
        return $this->view('emails.WithdrawCompetition')
            ->with('athlete', $this->athlete)
            ->with('entries', $this->entry)
            ->with('competition', $this->competition)
            ->with('event', $this->event)
            ->from($address, $name)
            ->replyTo($address, $name)
            ->subject($subject);
    }
}
