<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SellerForgetPassword extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $seller;
    protected $template;
    public $subject;
    public function __construct($seller,$template,$subject)
    {
        $this->seller=$seller;
        $this->subject=$subject;
        $this->template=$template;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $template=$this->template;
        $seller=$this->seller;
        return $this->subject($this->subject)->view('seller.seller_forget_pass_template',compact('seller','template'));
    }
}