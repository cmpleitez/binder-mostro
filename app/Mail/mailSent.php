<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class mailSent extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = 'Solicitud de confirmación - Acceso Binder';
    public $link;

    public function __construct($link)
    {
        $this->link = $link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('models.slices.mail_sent');
    }
}
