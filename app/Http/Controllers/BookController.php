<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookCollection;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function store(Request $request)
    {
        $this->authorize('create', [Book::class]);
        $user = Auth::user();
        $validated = $this->validate($request, [
            'name'   => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
        ]);
        return BookResource::make($user->books()->create($validated));
    }

    public function index(Request $request)
    {
        $this->authorize('viewAny', [Book::class]);
        $books = Book::latest()->with('user');
        if ($request->boolean('owned')) {
            $books->where('user_id', Auth::user()->getKey());
        }
        return BookCollection::make($books->paginate());
    }

    public function update(Request $request, Book $book)
    {
        $this->authorize('update', [Book::class, $book]);
        $validated = $this->validate($request, [
            'name'   => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
        ]);
        $book->update($validated);
        return BookResource::make($book->load('user'));
    }

    public function destroy(Book $book)
    {
        $this->authorize('delete', [Book::class, $book]);
        $book->delete();
        return response()->noContent();
    }

    public function show(Book $book)
    {
        $this->authorize('view', [Book::class, $book]);
        return BookResource::make($book);
    }
}
