<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Chat</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="/css/style.css"/>
</head>
<body>
<div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    <span id="current_user" class="hidden"></span><span email="{{ Auth::user()->email }}" id="user_current">{{ Auth::user()->name }}</span> <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
</div>
<div class="container" style="margin-top:30px;">
    <div class="row">
        <div class="col-md-8" style="margin: 0 auto;float: none;">
            <div class="panel panel-primary">
                <div class="panel-heading">
                   <h3>Chat</h3>
                </div>
                <div class="panel-body">
                    @foreach($chat as $c)
                        <div class="col-md-8"><strong id="username" email="{{ $c->email }}">{{ $c->getNameUser($c->email) }}</strong> : <span>{{ $c->message }}</span></div>
                    @endforeach
                </div>
                <div class="panel-footer">
                    <div class="input-group">
                        <input id="btn-input" type="text" class="form-control input-sm" placeholder="Type your message here..." />
                        <span class="input-group-btn">
                            <a href="#" class="btn btn-warning btn-sm" id="btn-chat">
                                Send</a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/js/jquery-1.11.2.min.js"></script>
<script src="https://js.pusher.com/3.2/pusher.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function(){
        var email = '{{ Auth::user()->email }}' ;
        Check_User_Current();
        $('#btn-chat').click(function(){
            var message = $('#btn-input').val();
            $.ajax({
                url: "/pusher/"+message,
                type: "get",
                success:function(data){
                    $('#btn-input').val('');
                    var html = '<div class="col-md-8 bg-right"><strong id="username">{{ Auth::user()->name }}</strong> : <span>'+message+'</span></div>';
                    $('.panel-body').append(html);
                }
            });
        });
        Pusher.logToConsole = true;

        var pusher = new Pusher('537a019b559f4fed1e18', {
          cluster: 'ap1',
          encrypted: true
        });

        var channel = pusher.subscribe('channel-name');
        channel.bind("App\\Events\\ChatMessageEvent", function(data) {
            var html = '<div class="col-md-8"><strong id="username"></strong> : <span>'+data.message+'</span></div>';
            $('.panel-body').append(html);
        });

    });
    function Check_User_Current(){
                var user_current = $('#user_current').html();
                $('#username').each(function() {
                console.log($(this).html());
                  if($(this).html() == user_current){
                    $(this).parent().addClass('bg-right');
                  }
                  else{
                      $(this).parent().addClass('bg-left');
                  }
                });
            }
</script>
</body>
</html>