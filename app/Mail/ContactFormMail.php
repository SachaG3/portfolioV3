<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data; // Déclarer une propriété publique pour stocker les données

    /**
     * Créer une nouvelle instance de message.
     *
     * @return void
     */
    public function __construct($data) // Passer les données au constructeur
    {
        $this->data = $data; // Stocker les données dans la propriété de l'objet
    }

    /**
     * Construire le message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from("contact@sachaguignard.fr", "Portfolio")
            ->replyTo($this->data['email'], $this->data['firstName'] . ' ' . $this->data['lastName'])
            ->subject('Nouvelle soumission de formulaire de contact')
            ->view('emails.contact')
            ->with([
                'data' => $this->data,
            ]);
    }

}
