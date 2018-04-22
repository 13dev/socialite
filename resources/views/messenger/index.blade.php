@extends('layouts.app')

@section('content')

<div class="row bg-faded">
  <div class="col-md-3 p-0 m-0">
    <div class="card h-100 rounded-0 rounded-left border-right">
      <div class="card-header p-2 d-inline-flex border-bottom" style="height: 53px!important;">
        <!-- Seamless Right Icon -->
        <div class="input-group input-group-seamless mr-2">
          <input type="text" class="form-control" aria-label="Search..." placeholder="Search...">
          <div class="input-group-append">
            <div class="input-group-text">
              <i class="fa fa-search"></i>
            </div>
          </div>
        </div>
        <button class="btn btn-outline-primary btn-sm btn-pill"><i class="fa fa-comments" style="font-size: 22px;"></i></button>
      </div>

      <div class="card-body h-100 p-0">
          <div class="card rounded-0 border-0">
            <ul class="list-unstyled">
              <div clas="mr-2" style="height: 30rem; overflow-y: hidden;" v-bar>
                <div>
                <threads></threads>
              </div>
              </div>
            </ul>
          </div>
      </div>
    </div>
  </div>
  <div class="col-md-9 p-0 m-0">
    <div class="card h-100 rounded-0 rounded-right">
      <div class="card-header p-3 border-bottom" style="height: 53px!important;">
        User <b>is typing...</b>
      </div>

      <div class="card-body p-0">
        <div class="d-flex align-items-start flex-column">
          <div  class="conversation w-100" id="messages">
            <div clas="mr-2" style="height: 30rem; overflow-y: hidden;" v-bar>
              <div >
                <messages></messages>
              </div>
            
            </div>

                   <!-- <div class="chat-bubble right mb-5">
                      <div class="p-3">
                        Message
                      </div>
                      <small class="d-inline-flex mt-1 ml-2 message-date" attr-date=""><i class="fa" style="margin-top:2px;">&#xf017;&nbsp;</i>15-04-2018 15:22:30</small>
                    </div>
                    
                  <div class="chat-bubble left mb-5">
                    <div class="p-3">
                      Message
                    </div>
                      <small class="d-inline-flex mt-1 ml-2 message-date" attr-date=""><i class="fa" style="margin-top:2px;">&#xf017;&nbsp;</i>15-04-2018 15:22:30</small>
                    </div> -->

                  </div>
                </div>
                <message-send></message-send>
              </div>
            </div>
          </div>
        </div>
      </div>

      @stop