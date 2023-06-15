<?php

namespace Liffe\Compras\App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MessageObs extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = 'Administracion Compras Mac';
    public $temail;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($alstore)
    {
        $this->temail = $alstore;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('compras::emails.layout.mailobs');
    }
}
