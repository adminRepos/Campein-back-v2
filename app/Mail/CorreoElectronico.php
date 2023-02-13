<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CorreoElectronico extends Mailable
{
    use Queueable, SerializesModels;
    public $id;
    public $nombre;
    public $tipoEmail;
    public $correo;
    public $pass;
    public $date;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($id, $nombre, $tipoEmail, $correo, $pass, $date)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->tipoEmail = $tipoEmail;
        $this->correo = $correo;
        $this->pass = $pass;
        $this->date = $date;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Correo Electronico',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        if($this->tipoEmail == 'recuperarPass'){
            // $today = new date('Y-m-d H:i:s');
            return new Content(
                view: 'mails.test',
                with: [
                    'id' => $this->id,
                    'nombre' => $this->nombre,
                    'date' => $this->date
                ],
            );
        }
        if($this->tipoEmail == 'registroUsuario'){
            return new Content(
                view: 'mails.registro-usuario',
                with: [
                    'nombre' => $this->nombre,
                    'correo' => $this->correo,
                    'pass' => $this->pass
                ],
            );
        }
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
