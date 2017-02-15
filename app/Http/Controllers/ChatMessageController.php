<?php

namespace App\Http\Controllers;
use Auth;
use App\ChatMessage;
use Illuminate\Http\Request;

class ChatMessageController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function chat(){
        $chat = ChatMessage::get();
        return view('chat',compact('chat'));
    }
    public function pusher($message){
//        $chat = new ChatMessage();
//        $chat->email = Auth::user()->email;
//        $chat->message = $message;
//        $chat->save();
    }
}
