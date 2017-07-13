<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Redis;
use DB;
use Auth;

class MessageController extends Controller
{
    //
    protected $redis;

    function __construct()
    {
        $this->redis = Redis::connection();
    }

    public function index(Request $request){


        $message = Message::where('id', 2)->first();
        $unread = Message::where('read', 0)
                    ->where('sender_id', $request->user()->id)
                    ->orderBy('created_at', 'desc')
                    ->get();


        return view('messages.index', compact('message', 'unread'));
    }

    public function getUserNotifications(Request $request)
    {
        $notifications = Message::where('read', 0)
            ->where('receiver_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();
        return response(['data' => $notifications], 200);
    }

    public function getPrivateMessages(Request $request)
    {
        $pms = PrivateMessage::where('receiver_id', $request->user()->id)->orderBy('created_at', 'desc')->get();
        return response(['data' => $pms], 200);
    }

    public function getPrivateMessageById(Request $request)
    {
        $pm = Message::where('id', $request->input('id'))->first();

        // if the message is not read, changing the status
        if ($pm->read == 0) {
            $pm->read = 1;
            $pm->save();

            $redis = Redis::connection();
            $redis->publish('messageRead', $pm);
            \Log::info('123');
        }

        return response(['data' => $pm], 200);
    }

    public function sendPrivateMessage(Request $request)
    {
        $attributes = [
            'sender_id' => $request->user()->id,
            'receiver_id' => $request->input('receiver_id'),
            'message' => $request->input('message'),
            'subject' => $request->input('subject'),
            'read' => 0,
        ];

        $pm = Message::create($attributes);
        $data = Message::where('id', $pm->id)->first();

        $redis = Redis::connection();
        $redis->publish('message', $data);

        return response(['data' => $data], 201);
    }

    public function getPrivateMessageSent(Request $request)
    {
        $pms = Message::where('sender_id', $request->user()->id)->orderBy('created_at', 'desc')->get();
        return response(['data' => $pms], 200);
    }
}
