<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AtendeBemMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The data to be used in the mail.
     */
    public $dados;

    /**
     * Create a new message instance.
     */
    public function __construct($dados)
    {
        $this->dados = $dados;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'AtendeBem - Redefinir Senha',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'AtendeBemEmail.reset-password-email',
            with: [
                'dados' => $this->dados,
                'name' => $this->dados['name'] ?? 'Usuário',
                'email' => $this->dados['email'] ?? '',
                'reset_url' => $this->dados['reset_url'] ?? '',
                'token' => $this->dados['reset_token'] ?? ''
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }


    public function build()
    {
        return $this->subject('AtendeBem - Redefinir Senha')
            ->view('AtendeBemEmail.reset-password-email')
            ->with([
                'dados' => $this->dados,
                'name' => $this->dados['name'] ?? 'Usuário',
                'email' => $this->dados['email'] ?? '',
                'reset_url' => $this->dados['reset_url'] ?? '',
                'token' => $this->dados['reset_token'] ?? ''
            ]);
    }
}