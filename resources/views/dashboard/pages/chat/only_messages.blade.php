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

                   <span>
                        <i class="fa
                        @if($m->seen_status)
                        fa-check-double text-success
                        @elseif($m->delivered_status)
                          fa-check-double
                        @else
                        fa-check
                        @endif

                        "></i>
                    </span>
                {{$m->message}}
                <br>
                <span class="" style="font-size: 10px;color: black">{{\Carbon\Carbon::parse($m->created_at)->format('h:i A')}}</span>
            </div>

        @else
            <div class="bubble you">
                {{$m->message}}
                <br>

                <span class="" style="font-size: 10px;color: black">{{\Carbon\Carbon::parse($m->created_at)->format('h:i A')}}</span>
            </div>

        @endif
    @endforeach

@endforeach
