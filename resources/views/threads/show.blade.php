@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row  justify-content-center ">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a href="#">{{$thread->creator->name}}</a> posted:
                        {{$thread->title}}</div>
                    <div class="card-body">
                        {{$thread->body}}
                    </div>
                </div>
            </div>
        </div>
        <div class="row  justify-content-center">
            <div class="col-md-8"><br>
                <h4 class="text-center text-success">Replies</h4>
                @foreach($thread->replies as $reply)
                    @include('threads.reply')
                @endforeach
            </div>
        </div>
        @guest()
            <p class="text-center">Please <a href="{{route('login')}}">Sign In</a> To Participate in The Forum</p>
        @endguest
        @auth()
            <div class="row  justify-content-center ">
                <div class="col-md-8"><br>
                    <form action="{{$thread->path().'/replies'}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <textarea name="body" id="body" class="form-control" placeholder="Write Your Replies"
                                      rows="5"></textarea>
                        </div>
                        <button type="submit" class="btn btn-default">Submit</button>
                    </form>
                </div>
            </div>
        @endauth
    </div>
@endsection
