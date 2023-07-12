<div class="user-list-box">
    <div class="search">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search">
            <circle cx="11" cy="11" r="8"></circle>
            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
        </svg>
        <input type="text" class="form-control" placeholder="Search"/>
    </div>
    <div class="people">
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

                            <span class="user-meta-time">2:09 PM</span>
                        </div>
                        {{--                        <span class="preview">--}}
                        {{--                            {{\Illuminate\Support\Str::limit(@$admin->last_message,10,'...')}}--}}
                        {{--                        </span>--}}
                        <span class="text-success admin_status_typing preview" id="admin_{{$admin->id}}"></span>
                    </div>
                </div>
            </div>
        @empty
        @endforelse


    </div>
</div>
@push('js')

@endpush
