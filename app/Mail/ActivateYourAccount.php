<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ActivateYourAccount extends Mailable
{
    use Queueable, SerializesModels;

    public $code;
    public $url;

    /**
     * Create a new message instance.
     *
     * @param string $code
     */
    public function __construct(string $code)
    {
        $this->code = $code;
        $this->url = route('user.activate', $code);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.activate_user_account');
    }
}