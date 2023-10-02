<?php

namespace App\Http\Controllers;

use App\Contracts\Services\StorageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class UploadController extends Controller
{
    /**
     * @param StorageService $storageService
     */
    public function __construct(
        private readonly StorageService $storageService
    ) {
    }

    /**
     * @return View
     */
    public function index(): View
    {
        $image = $this->storageService->getS3TemporaryUrl('/file/9a45371b-c1b6-46c0-adf4-637e26193648');

        return view('upload', compact('image'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $file = $request->file('file');
        $this->storageService->uploadFile($file, 'file', Str::orderedUuid());

        return back();
    }
}
