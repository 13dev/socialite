@extends('layouts.app')

@section('content')
<div class="columns is-gapless">
  <div class="column is-one-third">
    <!-- Threads -->
    <div class="card">
      <header class="card-header">
        <p class="card-header-title">
          <b-input placeholder="Search..."
                type="search"
                icon="magnify">
            </b-input>
        </p>
          <b-dropdown class="card-header-icon">
              <span class="icon" slot="trigger">
                <b-icon icon="dots-horizontal"></b-icon>
              </span>
            <b-dropdown-item>
              <b-icon icon="message-plus" size="is-small"></b-icon>
              New Thread
            </b-dropdown-item>
            <b-dropdown-item>Another action</b-dropdown-item>
            <b-dropdown-item>Something else</b-dropdown-item>
          </b-dropdown>
        
      </header>
      <!-- content -->
      <div>
        <ul>
          <div style="height: 22rem; overflow-y: hidden;" v-bar>
            <div>
              <threads></threads>
            </div>
          </div>
          </ul>
      </div>
      <!-- /content -->
      <footer class="card-footer">
        <a href="#" class="card-footer-item">Options</a>
      </footer>
    </div>
  </div>
  <div class="column">
    <!-- Messages -->
    <div class="card">
      <header class="card-header">
        <p class="card-header-title" style="height: 60px;">
          <user-typing></user-typing>
        </p>
      </header>
      <div>
        <div style="height: 22rem; overflow-y: hidden;" v-bar>
          <div id="messages">
            <messages></messages>
          </div>
        </div>
      </div>
      <footer class="card-footer">
        <message-send></message-send>
      </footer>
    </div>
  </div>
</div>
@stop