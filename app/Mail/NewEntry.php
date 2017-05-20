<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewEntry extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($athlete, $event, $entries, $competitions)
    {
        $this->athlete = $athlete;
        $this->entry = $entries;
        $this->event = $event;
        $this->competitions = $competitions;
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
        return $this->view('emails.NewEntry')
            ->with('athlete', $this->athlete)
            ->with('entries', $this->entry)
            ->with('event', $this->event)
            ->with('competitions', $this->competitions)
            ->from($address, $name)
            ->replyTo($address, $name)
            ->subject($subject);
    }
}
