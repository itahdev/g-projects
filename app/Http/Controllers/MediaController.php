<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MediaController extends Controller
{
    /**
     * @param string $path
     * @return StreamedResponse
     */
    public function show(string $path): StreamedResponse
    {
        return Storage::response($path);
    }
}
