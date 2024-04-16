<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
//use Illuminate\Mail\Mailables\Envelope;

class ContactMessage extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $data= [];
    public function __construct(Array $user)
    {
        //
         $this->data = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    /*public function GetFrom($add)
    {
        return $add;
    }*/

    public function build()
    {
       
        return $this
        ->view('emails.contact_message');
    }
}
