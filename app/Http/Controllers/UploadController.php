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
        private readonly StorageService $storageService,
    ) {
    }

    /**
     * @return View
     */
    public function index(): View
    {
//        $image = null;
        $image = $this->storageService->getImageUrl('/file/9a520dfd-54ce-4eff-8064-b1b0a21135d3');

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
