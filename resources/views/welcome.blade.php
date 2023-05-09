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
            </div>
          </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    </body>
</html>
