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
        $admins = Admin::query()->whereNot('admins.id', auth('admin')->id())
            ->select('admins.id', 'admins.name', 'admins.photo', 'admin_messages.created_at', 'admin_messages.message_id', 'messages.message', 'admin_messages.receiver_id','admin_messages.sender_id')
            ->leftJoin('admin_messages', function ($q) {
                $q->on('admins.id', 'admin_messages.sender_id')
                    ->where(function ($q) {
                        $q->where('admin_messages.sender_id', auth('admin')->id())
                            ->orWhere('admin_messages.receiver_id', auth('admin')->id());
                    })->where('admin_messages.type', 0)
                    ->orOn('admins.id', 'admin_messages.receiver_id')
                    ->where(function ($q) {
                        $q->where('admin_messages.sender_id', auth('admin')->id())
                            ->orWhere('admin_messages.receiver_id', auth('admin')->id());
                    })->where('admin_messages.type', 0);
            })
            ->leftJoin('messages', 'admin_messages.message_id', 'messages.id')
            ->orderByDesc('admin_messages.created_at')
            ->distinct()
            ->withCount('UnreadMessages as all_un_read_messages_count')
            ->withCount(['messages as un_read_messages_count' => function ($q) {
                $q->where('seen_status', 0)
                    ->where('receiver_id', auth('admin')->id());
            }])
            ->get()
            ->unique('id');
        $in_chat = 0;


        return view('dashboard.pages.chat.index', compact('admins', 'in_chat'));
    }

    public function getConversation(Request $request)
    {

        $partner = Admin::query()->findOrFail($request->admin_id);

        AdminMessage::query()->where([['receiver_id', auth('admin')->id()], ['sender_id', $request->admin_id]])->where('seen_status', 0)->each(function ($q) {
            $q->update(['seen_status' => 1]);
        });


        $messages = AdminMessage::query()->with('message:id,message')
            ->where('type', 0)
            ->where(function ($q) use ($partner) {
                $q->where('sender_id', auth('admin')->id())
                    ->where('receiver_id', $partner->id)
                    ->orWhere(function ($q) use ($partner) {
                        $q->where('sender_id', $partner->id)
                            ->where('receiver_id', auth('admin')->id());
                    });

            })->get();
        $view = view('dashboard.pages.chat.messages', compact('partner', 'messages'))->render();
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

    public function makeMessagesRead(Request $request)
    {

        AdminMessage::query()->where([['sender_id', $request->sender], ['receiver_id', $request->receiver]])->where('seen_status', 0)->each(function ($q) {
            $q->update(['seen_status' => 1]);
        });

    }
}
