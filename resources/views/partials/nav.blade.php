<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url('/home') }}">COSC 111</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="{{ url('/forum') }}">Discussion Forum</a></li>
                <li><a href="{{ url('/slide') }}">Slides</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                {{--<li><a href="#">My Grades</a></li>--}}
                {{--<li><a href="#">My Stats</a></li>--}}
                {{--<li><a href="#">My Notes</a></li>--}}
                @if (Auth::guest())
                    <li><a href="{{ url('/auth/register') }}">Create Account</a></li>
                    <li><a href="{{ url('/auth/login') }}">Login</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <li><a href="{{ url('/grade') }}">My Grades</a></li>
                            <li><a href="#">My Stats</a></li>
                            <li><a href="#">My Notes</a></li>
                            <li><a href="{{ url('/auth/logout') }}">Logout</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>