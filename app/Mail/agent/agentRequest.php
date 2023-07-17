<?php

namespace App\Mail\agent;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class agentRequest extends Mailable
{
    use Queueable, SerializesModels;

    public $details;
    protected $ccRecipients;
    public function __construct(array $ccRecipients, array $details)
    {
        $this->details = $details;
        $this->ccRecipients = $ccRecipients;
    }

    public function build()
    {
        return $this->view('emails.agent.agent_request')
        ->with([
            'details' => $this->details,
        ])
        ->cc($this->ccRecipients);
    }
}
