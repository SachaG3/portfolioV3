<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first-name' => 'required',
            'last-name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        $data = [
            'firstName' => $validated['first-name'],
            'lastName' => $validated['last-name'],
            'email' => $validated['email'],
            'content' => $validated['message'],
        ];

        Mail::to("contact@sachaguignard.fr")->send(new ContactFormMail($data));


        return back()->with('success', 'Votre message a été envoyé avec succès.');

    }
}
