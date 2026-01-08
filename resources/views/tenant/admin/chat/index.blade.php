@extends('tenant.layouts.tenant_master')

{{-- @section('content')
    <div class="main-panel">
    <div class="content d-flex">
        <!-- Left Sidebar: Users list -->
        <div class="user-list" style="width:200px; border-right:1px solid #ccc; padding:10px;">
            <h4>Users</h4>
            <ul>
                @foreach($users as $u)
                    <li>
                        <a href="{{ route('saas.chat.index', $u->id) }}">
                            {{ ucwords($u->name) }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Chat Panel -->
        <div class="chat-panel flex-grow-1" style="padding:10px;">
            <h3>Chat with {{ ucwords($user->name) ?? 'Select a user' }}</h3>

            @if(isset($conversation))
          <form id="chatForm">
            <div class="form-group row align-items-center">

                    @foreach($messages as $msg)
                        <p><b>{{ $msg->sender->name }}:</b> {{ $msg->message }}</p>
                    @endforeach


                    <input type="hidden" id="conversation_id" value="{{ $conversation->id }}">
                    <div class="d-flex align-items-center gap-2">
                    <input type="text" id="message" class="form-control rounded-pill"placeholder="Type a message"autocomplete="off">

                    <button type="submit" class="btn btn-primary rounded-circle" style="width:45px; height:45px;">
                        ➤
                    </button>
                </div>
            </form>
            @else
                <p>Select a user to start chat.</p>
            @endif
        </div>
    </div>
</div>
@endsection --}}


@section('content')
<div class="main-panel">
    <div class="content d-flex">
        <style>
            .chat-box {
                height: 350px;
                overflow-y: auto;
                background: #f0f2f5;
                padding: 10px;
            }
            .message {
                max-width: 70%;
                padding: 8px 12px;
                border-radius: 15px;
                margin-bottom: 8px;
                position: relative;
                font-size: 14px;
            }
            .me {
                background: #dcf8c6;
                margin-left: auto;
                border-bottom-right-radius: 0;
            }
            .other {
                background: #fff;
                margin-right: auto;
                border-bottom-left-radius: 0;
            }
            .time {
                font-size: 11px;
                color: #777;
                text-align: right;
            }
            .typing {
                font-style: italic;
                color: #777;
            }
            .status-dot {
                width: 8px;
                height: 8px;
                border-radius: 50%;
                display: inline-block;
            }
            .online { background: green; }
            .offline { background: gray; }

            .badge-danger {
                background-color: #ff646d;
                padding: 2px 4px;
                margin-left: 51px;
                margin-bottom: -20px;
                padding-bottom: 1px;
            }

        </style>

        <div style="width:220px; border-right:1px solid #ddd; padding:10px;">
            <input type="text" id="userSearch" class="form-control" placeholder="Search user...">

            <h5>Users</h5>
            <ul style="list-style:none; padding:0;">
                @foreach($users as $u)
                    <li style="margin-bottom:6px;">
                          @if($u->unread_count > 0)
                            <span class="badge badge-danger">
                                {{ $u->unread_count }}
                            </span>
                        @endif
                        <a href="{{ route('saas.chat.index', $u->id) }}"
                        style="text-decoration:none;
                        font-weight: {{ isset($user) && $user->id == $u->id ? 'bold' : 'normal' }};">
                            <div class="user-item">
                               {{ ucwords($u->name) }}
                            </div>
                        </a>


                    </li>
                @endforeach
            </ul>
        </div>




        <div>
            <h5>
                @if(isset($user))
                    <h5>
                        {{ ucwords($user->name) }}
                        <span class="status-dot online"></span>
                    </h5>
                @else
                    <h5>Select a user to start chat</h5>
                @endif
            </h5>

        </div>

        <div id="chatBox" class="chat-box">
            @foreach($messages as $msg)
                <div class="message {{ $msg->sender_id == auth()->id() ? 'me' : 'other' }}">
                    {{ $msg->message }}
                    <div class="time">
                        {{ $msg->created_at->format('h:i A') }}

                        @if($msg->sender_id == auth()->id())
                            <small>
                                {{ $msg->is_read ? '✓✓ Seen' : '✓ Sent' }}
                            </small>
                        @endif

                    </div>
                </div>
            @endforeach
        </div>

        <div id="typing" class="typing" style="display:none;">
            {{ $user->name }} is typing...
        </div>

        <form id="chatForm" class="mt-2">
            <div class="d-flex gap-2">
                <input type="hidden" id="conversation_id" value="{{ $conversation->id }}">
                <input type="text" id="message" class="form-control rounded-pill" placeholder="Type a message">
                <button class="btn btn-success rounded-circle" style="width:45px;height:45px;">➤</button>
            </div>
        </form>


    </div>
</div>

@endsection














@push('scripts')
<script>


$('#chatForm').submit(function(e){
    e.preventDefault();

    let msg = $('#message').val().trim();
    if (!msg) return;

    //  1. Instantly show message (NO refresh)
    $('#chatBox').append(`
        <div class="message me">
            ${msg}
            <div class="time">
                ${new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}
                ✔✔
            </div>
        </div>
    `);

    $('#chatBox').scrollTop($('#chatBox')[0].scrollHeight);

    //  2. Save + broadcast
    $.post("{{ route('saas.chat.send') }}", {
        _token: '{{ csrf_token() }}',
        conversation_id: '{{ $conversation->id }}',
        message: msg
    });

    $('#message').val('').focus();
});


// real time
Echo.private('chat.{{ $conversation->id }}')
.listen('MessageSent', (e) => {

    // 🔥 skip own message
    if (e.message.sender_id == {{ auth()->id() }}) return;

    $('#chatBox').append(`
        <div class="message other">
            ${e.message.message}
            <div class="time">
                ${new Date(e.message.created_at).toLocaleTimeString()}
            </div>
        </div>
    `);

    $('#chatBox').scrollTop($('#chatBox')[0].scrollHeight);
});



// typing indicate
let typingTimer;

$('#message').on('keyup', function () {
    Echo.private('chat.{{ $conversation->id }}')
        .whisper('typing', { name: '{{ auth()->user()->name }}' });

    clearTimeout(typingTimer);
    typingTimer = setTimeout(() => {
        $('#typing').hide();
    }, 1000);
});

Echo.private('chat.{{ $conversation->id }}')
    .listenForWhisper('typing', (e) => {
        $('#typing').show();
    });

// online /offline
Echo.join('presence-chat')
    .here((users) => {
        $('#userStatus').removeClass('offline').addClass('online');
    })
    .joining(() => {
        $('#userStatus').removeClass('offline').addClass('online');
    })
    .leaving(() => {
        $('#userStatus').removeClass('online').addClass('offline');
    });

// searching users
$('#userSearch').on('keyup', function () {
    let q = $(this).val().toLowerCase();

    $('.user-item').each(function () {
        $(this).toggle($(this).text().toLowerCase().includes(q));
    });
});

</script>
@endpush
