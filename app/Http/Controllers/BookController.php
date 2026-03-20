<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;

use App\Repositories\Interfaces\IBookRepository;


class BookController extends Controller
{
    protected $bookRepository;
    public function __construct(IBookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->bookRepository->getAllBooks();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {

        $data = $request->validated();

        if ($request->hasFile("cover")) {
            $data["cover"] = $request->file("cover")->store("covers", "public");
        }

        if ($request->hasFile("url")) {
            $data["url"] = $request->file("url")->store("books", "public");
        }

        $book = $this->bookRepository->create($data);
        return response()->json([ 
            "data" => $book
            ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $book = $this->bookRepository->findBook($id);
        return response()->json([
            "message" => "Libro obtenido.",
            "data" => $book
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, int $id)
    {
        $data = $request->validated();

        if ($request->hasFile("cover")) {
            $data["cover"] = $request->file("cover")->store("covers", "public");
        }

        if ($request->hasFile("url")) {
            $data["url"] = $request->file("url")->store("books", "public");
        }

         $updatedBook = $this->bookRepository->update($id, $data);

        return response()->json([
            "message" => "Libro actualizado.",
            "data" => $updatedBook
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $this->bookRepository->delete($id);
        return response()->json([
            "message" => "Libro eliminado."
        ], 200);
    }
}
