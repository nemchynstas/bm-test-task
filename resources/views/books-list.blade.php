@extends('layouts.app')

@section('content')

    <div class="container">
        <form action="" id="search_book" method="POST">
            <label for="search_title">Title</label>
            <input type="text" name="title" id="search_title">

            <label for="search_author">Author</label>
            <input type="text" name="author" id="search_author">
            <button>Search</button>
        </form>
        <div id="books_list" >
            @include('books-items')
        </div>

    </div>

    <script>

        $('#search_book').on('submit',function(ev){
            ev.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                url:'/search-book',
                type:'POST',
                data:formData,
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (msg) {
                    console.log(msg);
                    //location.reload();
                    $('#books_list').html(msg.books);
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
