<?php

namespace App\Http\Controllers;

use Illuminate\Http\Client\Factory as ClientFactory;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    /**
     * @param ClientFactory $client
     */
    public function __construct(
        private readonly ClientFactory $client,
    ) {
    }

    /**
     * @param string $path
     * @return Response
     */
    public function show(string $path): Response
    {
        $storagePath = Storage::url($path);
        $storageUrl = $this->client->get($storagePath);

        return response($storageUrl)->header(
            'Content-Type',
            $storageUrl ? $storageUrl->header('Content-Type') : 'image/jpeg'
        );
    }
}
