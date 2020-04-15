@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a href="#">{{$thread->creator->name}}</a> posted:
                        {{$thread->title}}</div>
                    <div class="card-body">
                        {{$thread->body}}
                    </div>
                </div>
                <br>
                @foreach($replies as $reply)
                    @include('threads.reply')
                @endforeach
                {{$replies->links()}}
                @guest()
                    <p class="text-center">Please <a href="{{route('login')}}">Sign In</a> To Participate in The Forum
                    </p>
                @endguest
                @auth()
                    <form action="{{$thread->path().'/replies'}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <textarea name="body" id="body" class="form-control" placeholder="Write Your Replies"
                                      rows="5"></textarea>
                        </div>
                        <button type="submit" class="btn btn-default">Submit</button>
                    </form>
                @endauth
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <p>
                            This Thread was created {{$thread->created_at->diffForHumans()}}
                            By <a href="#">{{$thread->creator->name}}</a>
                            and has {{$thread->replies_count}} {{Str::plural('Comment',$thread->replies_count )}}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
