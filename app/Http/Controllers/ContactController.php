<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        // Valider les champs du formulaire y compris le reCAPTCHA
        $request->validate([
            'first-name' => 'required|string|max:255',
            'last-name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string|min:10',
            'g-recaptcha-response' => 'required',
        ]);

        // Vérifiez le token reCAPTCHA avec Google
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('RECAPTCHA_SECRET_KEY'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);

        $result = $response->json();

        if (!$result['success'] || $result['score'] < 0.5) {
            return back()->withErrors(['captcha' => 'La validation du captcha a échoué, veuillez réessayer.']);
        }

        $data = [
            'firstName' => $request['first-name'],
            'lastName' => $request['last-name'],
            'email' => $request['email'],
            'content' => $request['message'],
        ];

        Mail::to("contact@sachaguignard.fr")->send(new ContactFormMail($data));


        return back()->with('success', 'Votre message a été envoyé avec succès.');

    }
}
