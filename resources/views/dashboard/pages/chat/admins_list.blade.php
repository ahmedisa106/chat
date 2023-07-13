@forelse($admins as $admin)
    <div class="person" data-chat="person6" data-admin_id={{$admin->id}}>
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
                <span class="preview">
                                                    {{\Illuminate\Support\Str::limit(@$admin->message,10,'...')}}
                                                </span>
                <span class="text-success admin_status_typing preview" id="admin_{{$admin->id}}"></span>
            </div>
        </div>
    </div>
@empty
@endforelse
