<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CredentialsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $email;
    public $password;
    

    public function __construct($name, $email, $password)
    {
        $this->name     = $name;
        $this->email    = $email;
        $this->password = $password;
 
         

    }

    public function build()
    {
        return $this->from(
            config('mail.from.address'),
            config('mail.from.name')
        )
            ->subject(' Login Account Credentials')
            ->view('emails.credentials');
    }
}