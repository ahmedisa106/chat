@forelse($admins as $admin)

    <div class="person" data-chat="person6" data-admin_id="{{$admin->id}}" style="background-color: {{  ($admin->un_read_messages_count) > 0 ? '#417c5624':""}} {{--{{$admin->receiver_id != null && @$partner_id == @$admin->id  ? '#d7d4d4':""}}--}} ">
        <div class="user-info">
            <div class="f-head">
                <img src="{{getFile($admin->photo)}}" alt="avatar">
                <i class="fa fa-circle admin-status admin-status-{{$admin->id}}" style="position: relative; top: -16px"></i>
            </div>

            <div class="f-body">
                <div class="meta-info">
                    <span class="user-name" data-name="{{$admin->name}}">{{$admin->name}}</span>
                    <span class="user-meta-time"> {{@$admin->created_at ? date('h:i A',strtotime($admin->created_at)) :""}} </span>
                </div>
                @if($admin->un_read_messages_count > 0)
                    <span class="preview d-inline-block text-success">
                        {{\Illuminate\Support\Str::limit(@$admin->message,10,'...')}}
                    </span>
                @else
                    <span class="preview d-inline-block">
                        {{\Illuminate\Support\Str::limit(@$admin->message,10,'...')}}
                    </span>
                @endif

                @if( $admin->un_read_messages_count > 0)
                    <div class="text-center font-weight-bold d-inline float-right when_un_read_messages" style="border-radius: 50%;  border: 4px solid #1fa855;   color: #FFFFFF;background-color: #1fa855">
                        {{$admin->un_read_messages_count}}
                    </div>

                @endif


                <span class="text-success admin_status_typing preview" id="admin_{{$admin->id}}"></span>
            </div>


        </div>
    </div>
@empty
@endforelse
