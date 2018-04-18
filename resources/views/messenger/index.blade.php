@extends('layouts.app')

@section('content')

<div class="row bg-faded">
    <div class="col-md-3 p-0 m-0">
        <div class="card h-100 rounded-0 border-right-0">
          <div class="card-header p-2">
            <div class="inner-addon right-addon">
              <i class="fa fa-search form-control-feedback"></i>
              <input type="text" class="form-control rounded-0 border-0" placeholder="search...">
            </div>
          </div>
          <div class="card-body h-100 p-0">
            <div class="card rounded-0 border-0" style="overflow-y: scroll;">
              <ul class="list-group list-group-flush">
                <threads :threads="{{ $threads }}"></threads>
            </ul>
          </div>
          </div>
        </div>
    </div>
    <div class="col-md-9 p-0 m-0">
        <div class="card h-100 rounded-0">
          <div class="card-header">
            Message
          </div>

          <div class="card-body p-0">
            <div class="d-flex align-items-start flex-column">
              <div class="conversation w-100 p-3" style="height: 30rem; overflow-y: scroll;">
                  <messages></messages>
                  
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

              <div class="inner-addon right-addon w-100">
                <i style="font-size:25px;" class="fa fa-send form-control-feedback mr-1"></i>
                <input type="text" class="form-control-lg rounded-0 border-right-0 border-left-0 border-bottom-0 form-control" placeholder="Mensagem..." aria-label="Mensagem...">
            </div>

            <!-- <div class="input-group-lg input-group mt-auto">
                <input type="text" class="rounded-0 border-right-0 border-left-0 border-bottom-0 form-control" placeholder="Mensagem..." aria-label="Mensagem...">
                <div class="input-group-append">
                  <button class="rounded-0 btn btn-primary" type="button">Enviar</button>
                </div>
              </div>-->
            </div>
          </div>
        </div>
    </div>
</div>

@stop