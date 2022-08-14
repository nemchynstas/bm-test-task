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
                <form action="" id="search_comment" method="POST">
                    <label for="search_text">Search by comment</label>
                    <input type="text" id="search_text" name="comment">

                    <label for="search_rate">Search by rate</label>
                    <select name="rate" id="search_rate">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>

                    <button>Search</button>
                </form>

                <div id="comments">
                    @include('comments-list')
                </div>
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

        $('#search_comment').on('submit',function(ev){
            ev.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                url:'/search-comment',
                type:'POST',
                data:formData,
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (msg) {
                    console.log(msg);
                    //location.reload();
                    $('#comments').html(msg.comments);
                },
                error: function(error) {
                    console.log(error);
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });
    </script>

@endsection
