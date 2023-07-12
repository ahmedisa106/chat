<div class="chat active-chat" data-chat="person6" data-partner_id="{{@$partner->id}}">
    <input type="hidden" id="partner_id" value="{{$partner->id}}">
    <div class="conversation-start-{{$partner->id}} conversation-start">
{{--        <span>Monday, 1:27 PM</span>--}}

        @foreach($messages as $message)

            @if($message->sender_id == auth('admin')->id())
                <div class="bubble me">
                    {{$message->message->message}}
                </div>
            @else
                <div class="bubble you">
                    {{$message->message->message}}
                </div>
            @endif
        @endforeach
    </div>

</div>
