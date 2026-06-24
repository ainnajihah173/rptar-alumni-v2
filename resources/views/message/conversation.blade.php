@extends('layouts.staff-base')

@section('content')
    <!-- Page Heading -->
    <div class="mb-3">
        <a href="{{ route('message.index') }}" class="text-decoration-none text-dark">
            <i class="fas fa-arrow-left"></i> Kembali ke Mesej
        </a>
    </div>
    <div class="container-fluid">
        <h3 class="text-center" style="color: #eb3a2a;">Perbualan</h3>
        <p class="text-center text-muted">Lihat perbualan penuh.</p>

        <div class="row">
            <div class="col-md-8 offset-md-2">
                <!-- Chat Container -->
                <div class="chat-container" id="chat-container">
                    @foreach ($conversation as $message)
                        <!-- Message Bubble -->
                        <div class="message-bubble {{ $message->sender_id == auth()->user()->id ? 'sent' : 'received' }}">
                            <div class="message-header">
                                <strong>{{ $message->sender->profile->full_name }}</strong>
                                <span class="message-time">{{ $message->created_at->format('h:i A') }}</span>
                            </div>
                            <div class="message-body">
                                <p>{{ $message->message }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Reply Form (Messaging Style) -->
                @if (!session()->has('success') && !$conversation->last()->replies()->exists())
                    <div class="reply-form" id="reply-form-container">
                        <form id="reply-form" action="{{ route('message.update', $conversation->last()->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="parent_id" id="parent_id" value="{{ $conversation->last()->id }}">

                            <!-- Reply Textarea -->
                            <div class="input-group">
                                <textarea name="message" id="reply-textarea" class="form-control" placeholder="Taip balasan anda..." rows="1" required></textarea>
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-paper-plane"></i> Hantar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                @else
                    <p class="text-center text-muted">Anda telah membalas mesej ini.</p>
                @endif
            </div>
        </div>
    </div>

    <style>
        /* Chat Container */
        .chat-container {
            max-height: 450px;
            overflow-y: auto;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #f9f9f9;
            margin-bottom: 10px; /* Space between chat and reply form */
        }

        /* Message Bubble */
        .message-bubble {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 10px;
            max-width: 70%;
            position: relative;
        }

        /* Sent Message (Logged-in User) */
        .message-bubble.sent {
            background-color: #eb3a2a;
            color: white;
            margin-left: auto;
        }

        /* Received Message (Other User)*/
        .message-bubble.received {
            background-color: #e9ecef;
            color: black;
            margin-right: auto;
        }

        /* Message Header */
        .message-header {
            font-size: 12px;
            margin-bottom: 5px;
        }

        .message-header strong {
            font-weight: bold;
        }

        .message-time {
            float: right;
            font-size: 10px;
            color: #666;
        }

        /* Message Body */
        .message-body {
            font-size: 14px;
        }

        /* Reply Form (Messaging Style) */
        .reply-form {
            position: sticky;
            bottom: 0;
            background-color: #fff;
            padding: 10px;
            border-top: 1px solid #ddd;
        }

        .reply-form textarea {
            resize: none; /* Disable resizing */
            border-radius: 20px; /* Rounded corners */
            padding: 10px;
            border: 1px solid #ddd;
        }

        .reply-form .input-group-append .btn {
            border-radius: 20px; /* Rounded corners for the button */
            margin-left: 10px; /* Space between textarea and button */
        }
    </style>

    <!-- JavaScript for AJAX -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Handle form submission
            $('#reply-form').on('submit', function(e) {
                e.preventDefault(); // Prevent the default form submission

                // Disable the submit button to prevent multiple submissions
                $('#reply-form button[type="submit"]').prop('disabled', true);

                // Get the form data
                const formData = $(this).serialize();

                // Send an AJAX request
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            // Clear the textarea
                            $('#reply-textarea').val('');

                            // Append the new message to the chat container
                            const newMessage = `
                                <div class="message-bubble sent">
                                    <div class="message-header">
                                        <strong>${response.data.sender_name}</strong>
                                        <span class="message-time">${response.data.time}</span>
                                    </div>
                                    <div class="message-body">
                                        <p>${response.data.message}</p>
                                    </div>
                                </div>
                            `;
                            $('#chat-container').append(newMessage);

                            // Scroll to the bottom of the chat container
                            $('#chat-container').scrollTop($('#chat-container')[0].scrollHeight);

                            // Hide the reply form and show a success message
                            $('#reply-form-container').hide();
                            $('#chat-container').append('<p class="text-center text-muted">Balasan berjaya dihantar.</p>');
                        }
                    },
                    error: function(xhr) {
                        alert('Ralat berlaku semasa menghantar balasan.');
                        // Re-enable the submit button in case of an error
                        $('#reply-form button[type="submit"]').prop('disabled', false);
                    },
                });
            });
        });
    </script>
@endsection