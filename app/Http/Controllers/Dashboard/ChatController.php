<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminMessage;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class ChatController extends Controller
{
    public function index()
    {
        $admins = Admin::query()->with(['lastMessage.message:id,message,created_at','lastMessageFromMe.message:id,message,created_at'])->whereNot('id', auth('admin')->id())->get(['id', 'name', 'status']);

        return view('dashboard.pages.chat.index', compact('admins'));
    }

    public function getConversation(Request $request)
    {
        $partner = Admin::query()->findOrFail($request->admin_id);

        $messages = AdminMessage::query()->with('message:id,message')
            ->where([['sender_id', auth('admin')->id()], ['receiver_id', $partner->id]])
            ->orWhere([['sender_id', $partner->id], ['receiver_id', auth('admin')->id()]])
            ->get();

        $view = View::make('dashboard.pages.chat.messages', compact('partner', 'messages'))->render();

        return response()->json($view);
    }

    public function sendMessage(Request $request)
    {
        $sender_id = $request->sender_id;
        $receiver_id = $request->receiver_id;
        $message_content = $request->message;

        try {
            DB::beginTransaction();
            $message = Message::query()->create(['message' => $message_content]);
            $message->admins()->attach($sender_id, ['receiver_id' => $receiver_id]);
            DB::commit();
            return response()->json(['message' => $message], 200);

        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json($exception->getMessage());
        }
    }
}