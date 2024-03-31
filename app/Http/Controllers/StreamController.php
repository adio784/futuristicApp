<?php

namespace App\Http\Controllers;

use App\Events\StreamStarted;
use App\Events\StreamStopped;
use App\Models\Stream;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StreamController extends Controller
{
    //
    public function start(Request $request)
    {
        $request->validate([
            'title'         => 'required|string|max:255',
            'description'   => 'nullable|string|max:500',
        ]);

        $stream_key             = 'fut' . date('Y') . date('n') . uniqid();
        $stream                 = new Stream();
        $stream->title          = $request->title;
        $stream->description    = $request->description;
        $stream->stream_key     = $stream_key;
        $stream->user_id        = Auth::id();
        $stream->is_live        = true;
        $stream->save();

        broadcast(new StreamStarted($stream));

        return response()->json(['message' => 'Stream started successfully', 'stream' => $stream], 200);
    }

    public function stop(Request $request)
    {
        $request->validate([
            'stream_id' => 'required|exists:streams,id',
        ]);

        $stream = Stream::findOrFail($request->stream_id);

        $stream->is_live = false;
        $stream->save();

        broadcast(new StreamStopped($stream));

        return response()->json(['message' => 'Stream stopped successfully'], 200);
    }
}
