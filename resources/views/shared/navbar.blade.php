<form id="logout-form" style="display: none;" action="{{ url('/logout') }}" method="POST">
    {{ csrf_field() }}
</form>
<nav class="navbar is-white is-fixed-top">
  <div class="navbar-brand">
    <a class="navbar-item" href="#">
      <img src="{{ asset('/assets/logo.png') }}" alt="Logo" width="112" height="28">
    </a>

    <a role="button" class="navbar-burger" data-target="nav-menu" aria-label="menu" aria-expanded="false">
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
    </a>
  </div>

  <div id="nav-menu" class="navbar-menu">
    <div class="navbar-start">
      <a class="navbar-item" href="https://bulma.io/">
        Home
      </a>
      <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link" href="/documentation/overview/start/">
            <figure class="image m-r-5">
              <img class="is-rounded" src="https://bulma.io/images/placeholders/128x128.png">
            </figure>
          Docs
        </a>
        <div class="navbar-dropdown is-boxed">
          <a class="navbar-item" href="/documentation/overview/start/">
            Overview
          </a>
          <a class="navbar-item" href="https://bulma.io/documentation/modifiers/syntax/">
            Modifiers
          </a>
          <a class="navbar-item" href="https://bulma.io/documentation/columns/basics/">
            Columns
          </a>
          <a class="navbar-item" href="https://bulma.io/documentation/layout/container/">
            Layout
          </a>
          <a class="navbar-item" href="https://bulma.io/documentation/form/general/">
            Form
          </a>
          <hr class="navbar-divider">
          <a class="navbar-item" href="https://bulma.io/documentation/elements/box/">
            Elements
          </a>
          <a class="navbar-item is-active" href="https://bulma.io/documentation/components/breadcrumb/">
            Components
          </a>
        </div>
      </div>
    </div>

    <div class="navbar-end">
        @guest
        <div class="navbar-item">
            <div class="field is-grouped">
                <p class="control">
                    <a class="bd-tw-button button" 
                        href="{{ route('login') }}">
                        <span class="icon">
                            <i class="mdi mdi-login-variant"></i>
                        </span>
                        <span>
                            Login
                        </span>
                    </a>
                </p>
                <p class="control">
                    <a class="button is-primary" 
                        href="{{ route('register') }}">
                        <span class="icon">
                            <i class="mdi mdi-account-plus"></i>
                        </span>
                        <span>Register</span>
                    </a>
                </p>
            </div>
        </div>
        @else
        <a class="navbar-item" style="display:inline-flex;" href="{{ route('messages') }}">
        Messages <unread-badge></unread-badge>
      </a>
      <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link" href="#">
            <figure class="image m-r-5">
              <img class="is-rounded" src="https://bulma.io/images/placeholders/128x128.png">
            </figure>
          {{ Auth::user()->name }}
        </a>
        <div class="navbar-dropdown is-boxed is-right">
          <a class="navbar-item" href="">
            Overview
          </a>
          <a class="navbar-item" href="">
            Modifiers
          </a>
          <a class="navbar-item" href="">
            Columns
          </a>
          <a class="navbar-item" href="">
            Layout
          </a>
          <a class="navbar-item" href="">
            Form
          </a>
          <hr class="navbar-divider">
          <a class="navbar-item" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
           Logout
          </a>
        </div>
      </div>
        @endguest
  </div>
</nav>
<!--
<nav class="navbar navbar-light bg-light fixed-top navbar-expand-md">
    <div class="container">
        {{ link_to_route('home', config('app.name', 'Laravel'), [], ['class' => 'navbar-brand']) }}

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarCollapse">
            @admin
            <ul class="navbar-nav">
                <li class="nav-item">
                    {{ link_to_route('admin.dashboard', __('dashboard.dashboard'), [], ['class' => 'nav-link']) }}
                </li>
            </ul>
            @endadmin

            <ul class="navbar-nav ml-auto">
                @guest
                <li class="nav-item">{{ link_to_route('login', __('auth.login'), [], ['class' => 'nav-link']) }}</li>
                <li class="nav-item">{{ link_to_route('register', __('auth.register'), [], ['class' => 'nav-link']) }}</li>
                @else
                <li class="nav-item message">
                    <a href="{{ route('messages') }}" class="nav-link" style="display:inline-flex;">
                        Messages <unread-badge></unread-badge>
                    </a>

                </li>
                <li class="nav-item dropdown">
                    <a v-pre href="#" class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>

                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        {{ link_to_route('users.show', __('users.public_profile'), Auth::user(), ['class' => 'dropdown-item']) }}
                        {{ link_to_route('users.edit', __('users.settings'), [], ['class' => 'dropdown-item']) }}

                        <div class="dropdown-divider"></div>

                        <a href="{{ url('/logout') }}"
                        class="dropdown-item"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        @lang('auth.logout')
                    </a>

                    <form id="logout-form" class="d-none" action="{{ url('/logout') }}" method="POST">
                        {{ csrf_field() }}
                    </form>
                </div>
            </li>
            @endguest
        </ul>
    </div>
</div>
</nav> -->

