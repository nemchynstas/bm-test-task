<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\Book;
use Auth;


class BooksController extends Controller
{
    public function booksList(){

        $books = Book::get();

        $data = [
            'books'=>$books
        ];
        return view('books-list')->with($data);
    }

    public function bookView(Request $request, $slug){

        $book = Book::where('id',$slug)->first();
        $comments = Comment::where('book_id', $slug)->get();

        $data = [
            'book' => $book,
            'comments' => $comments,
        ];

        return view('book-view')->with($data);
    }

    public function addComment(Request $request){

        $newComment = new Comment();
        $user = Auth::user();

        $newComment->user_id = $user->id;
        $newComment->book_id = $request->book_id;
        $newComment->rate = $request->rate;
        $newComment->comment = $request->comment;

        $newComment->save();

         return 1;
    }

    public function changeComment(Request $request){

        $date = date_default_timezone_get();
        $comment = Comment::where('id',$request->comment_id)->first();
        $comment->comment = $request->changed_comment;
        $comment->updated_at = $date;

        $comment->save();

        return 1;
    }

}
