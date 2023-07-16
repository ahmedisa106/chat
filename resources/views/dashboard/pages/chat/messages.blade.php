<input type="hidden" id="partner_id" value="{{$partner->id}}">
<div class="chat active-chat active-chat-{{@$partner->id}}" data-chat="person6" data-partner_id="{{@$partner->id}}">
    @foreach($messages as $day => $message)
        <div class="conversation-start-{{$partner->id}} conversation-start">

            <span>

            @if(\Carbon\Carbon::now()->format('d M Y') ==  $day )
                    today
                @elseif(\Carbon\Carbon::now()->subDay()->format('d M Y') ==  $day )
                    yesterday
                @else
                {{$day}}
                @endif

            </span>
        </div>
        @foreach($message as $m)
            @if($m->sender_id == auth('admin')->id())
                <div class="bubble me">
                    {{$m->message}}
                </div>
            @else
                <div class="bubble you">
                    {{$m->message}}
                </div>
            @endif
        @endforeach

    @endforeach


</div>
