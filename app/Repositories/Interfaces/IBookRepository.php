<?php

namespace App\Repositories\Interfaces;

interface IBookRepository
{
    public function getAllBooks();
    public function findBook(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
}