<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Car;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Liste les messages de l'utilisateur
     */
    public function index()
    {
        $userId = Auth::id();
        
        // Messages reçus
        $receivedMessages = Message::with(['sender', 'car'])
            ->where('receiver_id', $userId)
            ->latest()
            ->get()
            ->groupBy('sender_id');
            
        // Messages envoyés
        $sentMessages = Message::with(['receiver', 'car'])
            ->where('sender_id', $userId)
            ->latest()
            ->get()
            ->groupBy('receiver_id');
            
        return view('messages.index', compact('receivedMessages', 'sentMessages'));
    }
    
    /**
     * Affiche le formulaire pour envoyer un message
     */
    public function create(Request $request)
    {
        $car = null;
        $receiver = null;
        
        if ($request->has('car_id')) {
            $car = Car::findOrFail($request->input('car_id'));
            $receiver = $car->user;
        }
        
        if ($request->has('user_id')) {
            $receiver = User::findOrFail($request->input('user_id'));
        }
        
        return view('messages.create', compact('car', 'receiver'));
    }
    
    /**
     * Stocke un nouveau message
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'car_id' => 'required|exists:cars,id',
            'content' => 'required|string|max:1000',
        ]);
        
        // Empêche l'envoi de messages à soi-même
        if ($validated['receiver_id'] == Auth::id()) {
            return back()->withErrors(['receiver_id' => 'Vous ne pouvez pas envoyer de message à vous-même.']);
        }
        
        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $validated['receiver_id'],
            'car_id' => $validated['car_id'],
            'content' => $validated['content'],
            'is_read' => false
        ]);
        
        return redirect()->route('messages.index')->with('success', 'Message envoyé avec succès');
    }
    
    /**
     * Affiche une conversation entre deux utilisateurs
     */
    public function show(Request $request, $userId)
    {
        $otherUser = User::findOrFail($userId);
        
        // Messages entre les deux utilisateurs
        $messages = Message::with(['car'])
            ->where(function($query) use ($userId) {
                $query->where('sender_id', Auth::id())
                      ->where('receiver_id', $userId);
            })
            ->orWhere(function($query) use ($userId) {
                $query->where('sender_id', $userId)
                      ->where('receiver_id', Auth::id());
            })
            ->orderBy('created_at')
            ->get();
            
        // Marque les messages non lus comme lus
        Message::where('sender_id', $userId)
            ->where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);
            
        return view('messages.show', compact('messages', 'otherUser'));
    }
}