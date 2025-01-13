<?php

// app/Mail/ContactResponseMail.php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactResponseMail extends Mailable
{
    use Queueable, SerializesModels;

    public $contact;
    public $responseMessage;

    /**
     * Create a new message instance.
     *
     * @param $contact
     * @param $responseMessage
     */
    public function __construct($contact, $responseMessage)
    {
        $this->contact = $contact;
        $this->responseMessage = $responseMessage;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.contact_response')
                    ->with([
                        'name' => $this->contact->name,
                        'responseMessage' => $this->responseMessage,
                    ])
                    ->subject('Response to Your Contact Message');
    }
}
