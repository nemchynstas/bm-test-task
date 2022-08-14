@foreach($comments as $comment)
    <div class="comment-item-{{$comment->id}}" id="comment-item">
        <p>{{$comment->owner->name}}</p>
        <p id="comment-{{$comment->id}}">{{$comment->comment}}</p>
        <p>Rate: {{$comment->rate}}</p>
        @guest
        @else
            @if(auth()->user()->id == $comment->user_id)
                <button class="edit" id="edit-{{$comment->id}}" onclick="editComment('{{$comment->id}}')">Edit</button>
            @else
            @endif
        @endguest
        <p>Created: {{$comment->madeTimeAgo($comment->created_at)}}</p>
        <p>Updated: {{$comment->madeTimeAgo($comment->updated_at)}}</p>
    </div>
@endforeach
