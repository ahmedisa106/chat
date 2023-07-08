<!--  BEGIN SIDEBAR  -->
<div class="sidebar-wrapper sidebar-theme">

    <nav id="sidebar">
        <div class="shadow-bottom"></div>
        <ul class="list-unstyled menu-categories" id="accordionExample">
            <li class="menu">
                <a href="{{url('/dashboard')}}" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                       <i class="fa fa-home " ></i>
                        <span>Home</span>
                    </div>
                </a>
            </li>

            <li class="menu">
                <a href="{{url('/dashboard/admins')}}" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i class="fa fa-users " ></i>
                        <span>Admins</span>
                    </div>
                </a>
                <a href="{{url('/dashboard/admins')}}" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i class="fa fa-envelope " ></i>
                        <span>Chat</span>
                    </div>
                </a>
            </li>
        </ul>

    </nav>

</div>
<!--  END SIDEBAR  -->
