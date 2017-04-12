<header id="top-bar" class="navbar">
    <div class="container">
        <div class="navbar-header">

            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <div class="navbar-brand">
                <a href="{{ url() }}" >
                    <img id="logo" src="images/logo.png" alt="{{ config.website.name }}">
                </a>
            </div>
        </div>

        <nav class="collapse navbar-collapse navbar-left">
            <div class="main-menu">
                <ul class="nav navbar-nav navbar-left">
                    <li>
                        <a href="{{ url() }}" >Home</a>
                    </li>
                    <li><a href="{{ url('https://github.com/Neorej') }}" target="_blank">Github</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Pages <span class="caret"></span></a>
                        <div class="dropdown-menu">
                            <ul>
                                <li><a href="{{ url('index/notFound') }}">404 Page</a></li>
                            </ul>
                        </div>
                    </li>
                    {#
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Url <span class="caret"></span></a>
                        <div class="dropdown-menu">
                            <ul>
                                <li><a href="{{ url() }}">Url</a></li>
                                <li><a href="{{ url() }}">Url</a></li>
                                <li><a href="{{ url() }}">Url</a></li>
                            </ul>
                        </div>
                    </li>
                    #}
                    <li><a href="{{ url('index/contact') }}">Contact</a></li>
                </ul>
            </div>
        </nav>

        <nav class="collapse navbar-collapse navbar-right">
            <div class="main-menu">
                <ul class="nav navbar-nav navbar-right">
                    <li>{{ link_to('users/signin', 'Sign in') }}</li>
                    <li>{{ link_to('users/signup', 'Sign up') }}</li>
                </ul>
            </div>
        </nav>

    </div>
</header>