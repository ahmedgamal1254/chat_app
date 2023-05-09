<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use App\Events\MessageSent;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $users=User::where("id","!=",Auth::user()->id)->get();
        $messages=Message::where("sender_id","=",Auth::user()->id)->where("recieve_id","=",$id)
            ->orWhere("sender_id","=",$id)->orWhere("recieve_id","=",Auth::user()->id)->get();

        $id=$id;
        return view("chat",compact('users','messages','id'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user=User::find($request->recieve_id);

        $message=new Message;
        $message->text=$request->input("text");
        $message->sender_id=Auth::user()->id;
        $message->recieve_id=$request->input("recieve_id");
        $message->save();

        event(new MessageSent(Auth::user()->id,$message->text,$user));
    }

    /**
     * Display the specified resource.
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {
        //
    }
}
