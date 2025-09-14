<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface ImageStorage
{
    public function store(Request $request, string $folder = ''): array;

    public function delete(string $path): void;

    public function deleteMultiple(array $paths): void;
}
