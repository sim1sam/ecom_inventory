<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserRegistration extends Mailable
{
    use Queueable, SerializesModels;

    public $template;
    public $subject;
    public $user;
    public $verificationUrl;
    public function __construct($template,$subject,$user,$verificationUrl = null)
    {
        $this->template=$template;
        $this->subject=$subject;
        $this->user=$user;
        $this->verificationUrl=$verificationUrl;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   $template = $this->template;
        $subject = $this->subject;
        $user = $this->user;
        $verificationUrl = $this->verificationUrl;
        return $this->subject($this->subject)->view('user_registration_mail', compact('template','user','verificationUrl'));
    }
}
