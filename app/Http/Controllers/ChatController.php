<?php

namespace App\Http\Controllers;

use App\Events\Message;
use App\Models\Chat;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\TryCatch;
use Pusher\PushNotifications\PushNotifications;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function message(Request $request)
    {
        //
        $username   = $request->username;
        $message    = $request->message;

        event(new Message($username, $message));

        return [];
    }

    public function view(Request $request)
    {
        try {

            $request->validate([
                'sender'    => 'required|integer'
            ]);

            $chat = Chat::where('from_userId', $request->sender)->latest()->get();
            return response()->json([
                'statusCode'    => 200,
                'status'        => true,
                'message'       => 'Successfully loaded ...',
                'data'          => $chat
            ]);
        } catch (Exception $e) {

            return response()->json([
                'statusCode'    => 400,
                'status'        => false,
                'message'       => 'Error loading message ...',
                'data'          => $e
            ]);
        }
    }

    public function send(Request $request)
    {
        $request->validate([
            'message'   =>  'required|string|max:500',
            'receiver'  =>  'required|integer'
        ]);

        try {
            $receiver   = $request->receiver;
            $sender     = Auth::id();
            $message    = $request->message;

            $Chat = new Chat();
            $Chat->from_userId  = $sender;
            $Chat->to_userId    = $receiver;
            $Chat->message      = $message;
            $Chat->save();

            // Send push notification
            // $pusher = new PushNotications([
            //     'instanceId'    => config('services.pusher_beams.instance_id'),
            //     'secretKey'     => config('services.pusher_beams.secret_key')
            // ]);
            event(new Message('This is testing data', $receiver));

            // $pusher->publishToInterests(['new_message'], [
            //     'apns'  => ['apns'  => ['alert' => 'New message received']],
            //     'fcm'   => ['notification'  => ['title' => 'New Message', 'Body' => 'You have a new message']],
            // ]);

            return response()->json([
                'statusCode'    => 200,
                'status'        => true,
                'message'       => 'Message sent',
                'data'          =>  $Chat
            ]);
        } catch (\Throwable $th) {

            return response()->json([
                'statusCode'    => 400,
                'status'        => false,
                'message'       => $th,
            ]);
        }
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
    }
}
