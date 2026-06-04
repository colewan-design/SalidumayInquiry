<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class InquiryController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Inquiry');
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'first_name'    => 'required|string|max:100',
            'last_name'     => 'required|string|max:100',
            'topic'         => 'required|string|max:100',
            'email'         => 'required|email|max:255',
            'phone'         => 'required|string|max:30',
            'company'       => 'nullable|string|max:200',
            'brief'         => 'nullable|string|max:2000',
        ]);

        // Send notification email
        \Mail::raw(
            view('emails.inquiry-text', $validated)->render(),
            fn ($msg) => $msg
                ->to(config('mail.inquiry_to', env('INQUIRY_TO', 'hello@salidumay.com')))
                ->subject("New Inquiry from {$validated['first_name']} {$validated['last_name']}")
                ->replyTo($validated['email'], "{$validated['first_name']} {$validated['last_name']}")
        );

        return back()->with('success', 'Thank you! We will get back to you shortly.');
    }
}
