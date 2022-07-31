<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailToDPW extends Mailable
{
    use Queueable, SerializesModels;
    public $name;
    public $mail;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name,$mail)
    {
        $this->name=$name;
        $this->mail=$mail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mailtodpw')->with([
            'name' => $this->name ,
            'mail' => $this->mail ,
        ]);       
    }
}
