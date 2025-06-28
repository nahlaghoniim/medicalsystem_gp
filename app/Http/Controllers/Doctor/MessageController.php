<?php

// app/Http/Controllers/Doctor/MessageController.php
namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Message;

class MessageController extends Controller
{
   public function index()
{
    $messages = Message::orderBy('created_at', 'desc')->get(); // ✅ Fetch messages
    return view('dashboard.doctor.messages.index', compact('messages')); // ✅ Pass to view
}

    public function show($id)
    {
        $message = Message::findOrFail($id);
        $message->update(['is_read' => 1]);
        return view('dashboard.doctor.messages.show', compact('message'));
    }

    public function destroy($id)
    {
        $message = Message::findOrFail($id);
        $message->delete();

        return redirect()->route('dashboard.doctor.messages.index')->with('success', 'Message deleted.');
    }
}
