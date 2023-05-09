<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="{{ asset("css/style.css") }}">

    </head>
    <body>
        <div class="container py-5 px-4">
            <!-- For demo purpose-->
            <header class="text-center">
              <h1 class="display-4 text-white">Chat App</h1>
              <p class="text-white lead mb-0">use my app to open chat with users</p>
              <p class="text-white lead mb-4">welcome mr {{ Auth::user()->name }}
                <a href="https://bootstrapious.com" class="text-white">
                  <u></u></a>
              </p>
            </header>

            <div class="row rounded-lg overflow-hidden shadow">
              <!-- Users box-->
              <div class="col-5 px-0">
                <div class="bg-white">

                  <div class="bg-gray px-4 py-2 bg-light">
                    <p class="h5 mb-0 py-1">Recent</p>
                  </div>

                  <div class="messages-box">
                    <div class="list-group rounded-0">
                        @foreach ($users as $user)
                            <a href="{{ route("chat",$user->id) }}" class="list-group-item list-group-item-action active text-white rounded-0">
                                <div class="media"><img src="https://bootstrapious.com/i/snippets/sn-chat/avatar.svg" alt="user" width="50" class="rounded-circle">
                                <div class="media-body ml-4">
                                    <div class="d-flex align-items-center justify-content-between mb-1">
                                    <h6 class="mb-0">{{ $user->name }}</h6>
                                    <small class="small font-weight-bold">25 Dec</small>
                                    </div>
                                </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                  </div>
                </div>
              </div>
              <!-- Chat Box-->
              <div class="col-7 px-0">
                <div class="px-4 py-5 chat-box bg-white" id="chat_data">
                  @foreach ($messages as $message)
                    @if($message->sender_id == Auth::user()->id)
                        <!-- Sender Message-->
                        <div class="media w-50 mb-3">
                            <img src="https://bootstrapious.com/i/snippets/sn-chat/avatar.svg" alt="user" width="50" class="rounded-circle">
                            <div class="media-body ml-3">
                            <div class="bg-light rounded py-2 px-3 mb-2">
                                <p class="text-small mb-0 text-muted">{{ $message->text }}</p>
                            </div>
                            <p class="small text-muted">12:00 PM | Aug 13</p>
                            </div>
                        </div>
                    @else
                        <!-- Reciever Message-->
                        <div class="media w-50 ml-auto mb-3">
                            <div class="media-body">
                            <div class="bg-primary rounded py-2 px-3 mb-2">
                                <p class="text-small mb-0 text-white">{{ $message->text }}</p>
                            </div>
                            <p class="small text-muted">12:00 PM | Aug 13</p>
                            </div>
                        </div>
                    @endif
                  @endforeach
                </div>
                <!-- Typing area -->
                <form action="#" id="send_chat" class="bg-light">
                  <div class="input-group">
                    @csrf
                    <input type="text" id="text" name="text" placeholder="Type a message" aria-describedby="button-addon2" class="form-control rounded-0 border-0 py-4 bg-light">
                    <input type="hidden" name="recieve_id" value="{{ $id }}">
                    <div class="input-group-append">
                      <button id="button-addon2" type="submit" class="btn btn-link"> <i class="fa fa-paper-plane"></i></button>
                    </div>
                  </div>
                </form>

              </div>
            </div>
          </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script
            src="https://code.jquery.com/jquery-3.6.4.min.js"
            integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8="
            crossorigin="anonymous"></script>

        <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <!-- Load Bootstrap JavaScript files -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#send_chat').submit(function(event) {
                    // Prevent the default form submission
                    event.preventDefault();

                    // Get the form data
                    var formData = $(this).serialize();

                    // Send the form data via AJAX
                    $.ajax({
                        type: 'POST',
                        url: '{{ route("store") }}',
                        data: formData,
                        success: function(response) {
                            document.getElementById("chat_data").innerHTML+=`
                            <div class="media w-50 mb-3">
                                <img src="https://bootstrapious.com/i/snippets/sn-chat/avatar.svg" alt="user" width="50" class="rounded-circle">
                                <div class="media-body ml-3">
                                <div class="bg-light rounded py-2 px-3 mb-2">
                                    <p class="text-small mb-0 text-muted">${document.getElementById("text").value}</p>
                                </div>
                                <p class="small text-muted">12:00 PM | Aug 13</p>
                                </div>
                            </div>
                            `

                            document.getElementById("text").value=''
                            document.getElementById("chat_data").scrollTop=document.getElementById("chat_data").scrollHeight;
                        },
                        error: function(xhr, status, error) {
                            // Handle the error response
                            console.log(xhr.responseText);
                        }
                        });
                    });


                });


                // Enable pusher logging - don't include this in production
                Pusher.logToConsole = true;

                var pusher = new Pusher('653c4bb5ad9bdc1559f0', {
                    cluster: 'eu'
                });

                var channel = pusher.subscribe('message{{ Auth::user()->id }}');
                    channel.bind('my-event', function(data) {
                        var data=JSON.stringify(data)
                        const parsedData = JSON.parse(data);
                        document.getElementById("chat_data").innerHTML+=`
                        <div class="media w-50 ml-auto mb-3">
                            <div class="media-body">
                            <div class="bg-primary rounded py-2 px-3 mb-2">
                                <p class="text-small mb-0 text-white">${parsedData.message}</p>
                            </div>
                            <p class="small text-muted">12:00 PM | Aug 13</p>
                            </div>
                        </div>
                        `
                        document.getElementById("chat_data").scrollTop=document.getElementById("chat_data").scrollHeight;
                });

                document.getElementById("chat_data").scrollTop=document.getElementById("chat_data").scrollHeight;
        </script>
    </body>
</html>
