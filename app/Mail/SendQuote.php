<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendQuote extends Mailable
{
    use Queueable, SerializesModels;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $vendedor, $cliente, $file;
    public function __construct($vendedor, $cliente, $file)
    {
        $this->vendedor = $vendedor;
        $this->cliente = $cliente;
        $this->file = $file;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.quotepdf.promolife')
            ->with('url', url('/'))
            ->with('cliente', $this->cliente)
            ->with('vendedor', $this->vendedor)
            ->subject('Cotizacion')
            ->from(auth()->user()->email, 'Cotizacion Realizada')
            ->attach(public_path() . $this->file, [
                'as' => 'Cotizacion.pdf',
                'mime' => 'application/pdf',
            ]);
    }
}
