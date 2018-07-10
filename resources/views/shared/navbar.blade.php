<form id="logout-form" style="display: none;" action="{{ url('/logout') }}" method="POST">
    {{ csrf_field() }}
</form>
<nav class="navbar is-white is-fixed-top" style="border-bottom: 1px solid #168efe;
    box-shadow: 0 3px 20px #168efe7a;">
  <div class="navbar-brand">
    <a class="navbar-item" href="/">
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
      <a class="navbar-item" href="/">
        <span class="icon">
          <i class="mdi mdi-home"></i>
        </span>
        Home
      </a>
      <a class="navbar-item" href="{{ route('about') }}">
        <span class="icon">
          <i class="mdi mdi-information-outline"></i>
        </span>
        About
      </a>
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
        <a class="navbar-item">
          <b-icon icon="plus"></b-icon>
          New Post
        </a>
        <notifications></notifications>
        
        @if(\Route::current()->getName() != 'messages')
          <a class="navbar-item" style="display:inline-flex;" href="{{ route('messages') }}">
            <unread-badge></unread-badge>
          </a>
        @endif
      <div class="navbar-item navbar-item-max has-dropdown is-hoverable">
        <a class="navbar-link" href="#">
            <figure class="image m-r-5">
              <img class="is-rounded" src="{{ asset(Auth::user()->profileImage('tiny')) }}">
            </figure>
          {{ Auth::user()->name }}
        </a>
        <div class="navbar-dropdown is-boxed is-right">
          @admin
            <a class="navbar-item" href="">
              <span class="icon">
                <i class="mdi mdi-verified"></i>
              </span>
              Admin
            </a>
          @endadmin
          <a class="navbar-item" href="">
            <span class="icon">
              <i class="mdi mdi-account-settings-variant"></i>
            </span>
            Settings
          </a>
          <a class="navbar-item" href="{{ route('profile', ['username' => Auth::user()->username ])}}">
            <span class="icon">
              <i class="mdi mdi-account-multiple"></i>
            </span>
            My Profile
          </a>
          <hr class="navbar-divider">
          <a class="navbar-item" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
            <span class="icon">
              <i class="mdi mdi-logout-variant"></i>
            </span>
           Logout
          </a>
        </div>
      </div>
        @endguest
  </div>
</nav>


