<div class="card">
    <div class="card-header">
        <div class="level">
            <h5  class="flex">
                <a href="#">{{$reply->owner->name}}</a> said
                {{$reply->created_at->diffForHumans() }}...
            </h5>
            <div>
                <form action="replies/{{$reply->id}}/favorites" method="POST">
                    @csrf
                    <button class="btn" type="submit">
                        {{$reply->favorites()->count()}}
                        <i class="fas fa-heart"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="card-body">
        {{$reply->body}}
    </div>
</div> <br>
