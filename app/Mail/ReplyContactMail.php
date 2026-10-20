<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReplyContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $replyMessage;
    public $originalMessage;
    public $topic;

    public function __construct($replyMessage, $originalMessage, $topic)
    {
        $this->replyMessage = $replyMessage;
        $this->originalMessage = $originalMessage;
        $this->topic = $topic;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Re: Your Inquiry to BACK2ERAS (' . strtoupper($this->topic) . ')',
        );
    }

    public function content(): Content
    {
        // Kita bisa langsung menggunakan view berupa string (teks biasa) agar simpel
        return new Content(
            view: 'emails.reply',
        );
    }
}
