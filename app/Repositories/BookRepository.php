<?php

namespace App\Repositories;

use App\Models\Book;
use App\Repositories\Interfaces\IBookRepository;

class BookRepository implements IBookRepository
{
    public function getAllBooks()
    {
        return Book::with("category:id,name")->select("id", "cover", "title", "slug", "description", "price", "num_pages", "category_id", "url")->orderByDesc('created_at')->paginate(10);
    }

    public function findBook($id)
    {
        return Book::with("category:id,name")->select("id", "cover", "title", "slug",  "description", "price", "num_pages", "category_id", "url")->findOrFail($id);
    }

    public function create(array $data)
    {
        $currentBook = Book::create($data);
        return $currentBook->only(["id", "cover", "title", "slug", "description", "price", "num_pages", "category_id", "url"]);
    }

    public function update($id, array $data)
    {
        $book = Book::findOrFail($id);
        $book->update($data);
        return $book->only(["id", "cover", "title", "slug", "description", "price", "num_pages", "category_id", "url"]);
    }

    public function delete($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
        return true;
    }
}