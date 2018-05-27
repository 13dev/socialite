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
                icon="magnify"
                style="width:100%!important;">
            </b-input>
        </p>
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
        <a href="#" class="card-footer-item">
          <b-icon icon="message-plus" size="is-small"></b-icon>
          New Thread
        </a>
      </footer>
    </div>
  </div>
  <div class="column">
    <!-- Messages -->
    <div class="card">
      <header class="card-header">
        <div class="card-header-title" style="height: 60px;">
          <thread-info></thread-info>
          <user-typing></user-typing>
        </div>
        <div class="card-header-icon">
          <user-online></user-online>
        </div>
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