<?php

namespace App\Http\Controllers;

use App\Contracts\Services\MediaService;
use Illuminate\Http\Client\Factory as ClientFactory;
use Illuminate\Http\Request;
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
     * @return Response
     */
    public function show(): Response
    {
        $storagePath = Storage::url('/file/9a522513-1ec7-4fb6-8de4-4c853fee3fb4');
        $storageUrl = $this->client->get($storagePath);
        return response($storageUrl)->header(
            'Content-Type',
            $storageUrl ? $storageUrl->header('Content-Type') : 'image/jpeg'
        );
    }
}
