<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderShipped extends Mailable
{
    use Queueable, SerializesModels;

    public $url;
    public $message;
    public $name;
    public $email;
    public $product;
    public $phone;
    public $welcome;
    public $cus_name;
    public $type;
    public $subject;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($message, $url, $name, $phone, $email, $product, $welcome, $cus_name, $type, $subject)
    {
        $this->url = $url;
        $this->message = $message;
        $this->name = $name;
        $this->email = $email;
        $this->product = $product;
        $this->phone = $phone;
        $this->welcome = $welcome;
        $this->cus_name = $cus_name;
        $this->type = $type;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('mail@linktechbd.com','Link-Up Technology Ltd.')->subject($this->subject)->markdown('emails');
    }
}
