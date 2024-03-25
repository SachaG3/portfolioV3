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
            'emails' => 'required|emails',
            'message' => 'required',
        ]);

        $data = [
            'firstName' => $validated['first-name'],
            'lastName' => $validated['last-name'],
            'emails' => $validated['emails'],
            'content' => $validated['message'],
        ];

        Mail::to($validated['emails']->email)->send(new ContactFormMail($data));


        return back()->with('success', 'Votre message a été envoyé avec succès.');

    }
}
