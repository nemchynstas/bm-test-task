@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="book-info">
            <p>Title: {{$book->title}}</p>
            <p>Author: {{$book->author}}</p>
        </div>
        <div class="book-comments">
            <div class="create-comment">
                @guest
                    <p><a href="/register">Register</a> or <a href="/login">Login</a> before left comment</p>
                @else
                <form action="" id="send-comment" method="POST">

                    <label for="">Rate</label>
                    <select name="rate" id="rate">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>

                    <label for="comment">Comment</label>
                    <textarea name="comment" id="comment" cols="30" rows="10"></textarea>

                    <button onclick="addComment()">Send</button>
                </form>

                @endguest
            </div>
            <div class="comments-list">
                @foreach($comments as $comment)
                    <div class="comment-item-{{$comment->id}}" id="comment-item">
                        <p>{{$comment->owner->name}}</p>
                        <p id="comment-{{$comment->id}}">{{$comment->comment}}</p>
                        <p>{{$comment->rate}}</p>
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
            </div>
        </div>
    </div>

    <script>
        $('#send-comment').on('submit',function(ev){
            ev.preventDefault();
            var formData = new FormData(this);

            formData.append('book_id',{{$book->id}});

            $.ajax({
                url:'/add-comment',
                type:'POST',
                data:formData,
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (msg) {
                    console.log(msg);
                    location.reload();
                },
                error: function(error) {
                    console.log(error);
                },
                cache: false,
                contentType: false,
                processData: false
            })
        });

        function editComment(id){
            var oldVal = $('#comment-'+id).text();

            $('#comment-'+id).hide();
            $('#comment-'+id).after(`<textarea name="changed_comment" id="changed_comment-${id}" cols="30" rows="10">${oldVal}</textarea>`);

            $('#edit-'+id).hide();
            $('#edit-'+id).after(`<button onclick="saveComment('${id}')">Save</button>`);
        }

        function saveComment(id){
            var formData = new FormData();
            formData.append('comment_id',id);
            formData.append('changed_comment',$('#changed_comment-'+id).val());

            $.ajax({
                url:'/save-comment',
                type:'POST',
                data:formData,
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (msg) {
                    console.log(msg);
                    location.reload();
                },
                error: function(error) {
                    console.log(error);
                },
                cache: false,
                contentType: false,
                processData: false
            })
        }
    </script>

@endsection
