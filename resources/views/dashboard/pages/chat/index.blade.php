@extends('dashboard.layouts.master')
@push('css')

    <link href="{{asset('assets/dashboard')}}/assets/css/apps/mailing-chat.css" rel="stylesheet" type="text/css"/>
@endpush
@section('content')
    <div class="chat-section layout-top-spacing">
        <div class="row">

            <div class="col-xl-12 col-lg-12 col-md-12">

                <div class="chat-system">
                    <div class="hamburger">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu mail-menu d-lg-none">
                            <line x1="3" y1="12" x2="21" y2="12"></line>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <line x1="3" y1="18" x2="21" y2="18"></line>
                        </svg>
                    </div>
                    @include('dashboard.pages.chat.user_list')
                    <div class="chat-box">

                        <div class="chat-not-selected">
                            <p>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-square">
                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                                </svg>
                                Click User To Chat
                            </p>
                        </div>

                        @include('dashboard.pages.chat.body')


                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{asset('assets/dashboard')}}/assets/js/custom.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="{{asset('assets/dashboard/assets/js/apps/mailbox-chat.js')}}"></script>
    <!-- END PAGE LEVEL SCRIPTS -->

    {{-- get conversations when chose the partner--}}
    <script>
        var page = 1;
        var current_page = 0;
        $(document).on('click', '.person', function (e) {
            page = 1;
            current_page = 0;
            e.preventDefault();
            $('input[name="message"]').val('')
            // $(this).css('background-color', '#417c5624').siblings().css('background-color', '')
            var admin_id = $(this).data('admin_id');
            $('.admin_status_typing_inside_chat').attr('id', admin_id)
            partner_id = admin_id;


            socket.emit('i_open_our_chat', {
                partner_id,
                'sender': '{{auth('admin')->user()->id}}'
            })

            $.ajax({
                type: "get",
                url: "{{route('dashboard.chat.getConversation')}}",
                data: {
                    admin_id
                },
                beforeSend: function () {
                    $('#chat-conversation-box-scroll').empty()
                },
                success: function (response) {
                    $('#chat-conversation-box-scroll').html(response);
                    const getScrollContainer = document.querySelector('.chat-conversation-box');
                    getScrollContainer.scrollTo(0, getScrollContainer.scrollHeight);
                    // $('.user-info .when_un_read_messages').remove();
                    // $('.user-info .text-success').removeClass('text-success');

                    var in_chat = partner_id == admin_id ? 1 : 0
                    getSortedAdmins(in_chat, partner_id);

                },
                error: function () {

                }
            })
        })
    </script>

    {{-- send message--}}
    <script>

        // var last_date_updated = '';
        $('.chat-form').on('submit', function (e) {
            e.preventDefault();
            var sender_id = '{{auth('admin')->id()}}',
                receiver_id = partner_id,
                message = $('input[name="message"]').val();

            if (message !== '') {
                sendMessage(sender_id, receiver_id, message);
            }
        });

        function sendMessage(sender_id, receiver_id, message) {
            // var date = $('.active-chat .conversation-start').text();
            // last_date_updated = date.trim();
            $.ajax({
                type: "post",
                url: "{{route('dashboard.chat.sendMessage')}}",
                headers: {
                    'X-CSRF-TOKEN': "{{csrf_token()}}",
                },
                data: {
                    sender_id,
                    receiver_id,
                    message
                },
                beforeSend: function () {

                },
                success: function (response) {
                    let chat = ``;
                    // if (last_date_updated === '' || last_date_updated !== 'today') {
                    //     last_date_updated = 'today';
                    //     chat += `<div class="conversation-start">
                    //                     <span>today</span>
                    //
                    //             </div>`;
                    // }


                    chat += `
                            <div class="bubble me">
                             <span>
                                 <i class="fa fa-check"></i>
                            </span>
                                ${message}
                                </br>
                                <span class=""  style="font-size: 10px;color: black">${moment().format(' hh:mm A')}</span>
                           </div>
                           `;


                    $('.mail-write-box').val('');

                    socket.emit('who_partner_you_chat', {
                        'sender_id': "{{auth('admin')->id()}}",
                        'partner_id': partner_id
                    })
                    socket.emit('admin_send_message', {
                        message,
                        sender_id,
                        receiver_id,
                        'sender_name': "{{auth('admin')->user()->name}}"
                    });

                    $('.active-chat-' + receiver_id).append(chat);
                    const getScrollContainer = document.querySelector('.chat-conversation-box');
                    getScrollContainer.scrollTop = getScrollContainer.scrollHeight;

                    getSortedAdmins(1, receiver_id);
                },
                error: function (response) {

                }
            })
        }

    </script>

    <script>
        // when admin  writing
        var typingTimer;
        $('.mail-write-box').on('keyup', function () {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(user_finished, 1000);

            socket.emit('admin_is_typing', {
                admin_id: '{{auth('admin')->id()}}',
                partner_id,
            })
        })
        $('.mail-write-box').on('keydown', function () {
            clearTimeout(typingTimer);
        });


        function user_finished() {
            socket.emit('admin_stop_typing', {
                admin_id: '{{auth('admin')->id()}}',
                partner_id,
            })
        }

    </script>
    <script>

        //  when window scroll top

        $('.chat-conversation-box').scroll(function () {
            if ($(this).scrollTop() <= 0 && page !== current_page) {
                page++;
                getConversations(page);
            }
        });

        function getConversations(page) {
            var url = '{{route('dashboard.chat.getConversation')}}' + '?page=' + page;
            $.ajax({
                type: 'get',
                url,
                data: {
                    'admin_id': partner_id
                },
                success: function (response) {

                    if (response !== '') {
                        const getScrollContainer = document.querySelector('.chat-conversation-box');
                        getScrollContainer.scrollTop = 20;
                        $('.active-chat-' + partner_id).prepend(response)
                    } else {
                        current_page = page;
                    }


                }
            })

        }


    </script>

@endpush
