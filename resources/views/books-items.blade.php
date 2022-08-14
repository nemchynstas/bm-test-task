@foreach($books as $book)
    <div class="book">
        <p>Title: {{$book->title}}</p>
        <p>Author: {{$book->author}}</p>
        <a href="/book-view/{{$book->id}}">Go to-></a>
    </div>
@endforeach
