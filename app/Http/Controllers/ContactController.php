<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Mail\ContactResponseMail;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Store a newly created contact message in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
        ]);

        try {
            Contact::create($validatedData);
            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Failed to save message. Please try again later.'], 500);
        }
    }

    /**
     * Fetch all contact messages.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getContactMessages()
    {
        $messages = Contact::all(); // Fetch all contact messages from the database
        return response()->json($messages);
    }

    public function sendResponse(Request $request)
    {
        $validatedData = $request->validate([
            'messageId' => 'required|exists:contacts,id',
            'response' => 'required|string|max:1000',
        ]);

        $contact = Contact::findOrFail($validatedData['messageId']);
        $responseMessage = $validatedData['response'];

        try {
            Mail::to($contact->email)->send(new ContactResponseMail($contact, $responseMessage));
            $contact->responded = true; // Set responded status to true
            $contact->save();
            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Failed to send response. Please try again later.'], 500);
        }
    }

}
