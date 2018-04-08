@extends('layouts.app')

@section('content')

<div class="content" style="display: table;">
  <span class="left" style="display: table-cell;">
      <div class="card" style="border-radius: 0; border-right: 0;width: 20rem;">
        <div class="card-header" style="border-radius: 0;">
          ehheheh
        </div>


        <div class="card-body" style="padding: 0;">
          <div class="card" style="max-height:30rem; overflow-y: scroll;  border:0; border-radius: 0; border-right: 1px solid rgba(0, 0, 0, 0.125);">
            <ul class="list-group list-group-flush">
            @each('messenger.partials.thread', $threads, 'thread', 'messenger.partials.no-threads')
          </ul>
        </div>
        </div>
      </div>
  </span>
  <span class="right" style=" display: table-cell; width: 100%;">
    <div class="card" style="border-radius: 0;">
      <div class="card-header" style="border-radius: 0;">
        Message
      </div>


      <div class="card-body" style="padding: 0;">
        <input type="text" class="form-control">
        <button class="btn btn-outline-primary"><i class="fa fa-send"></i></button>
      </div>
    </div>
  </span>
</div>

@stop