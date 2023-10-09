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
        return view('upload');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $file = $request->file('file');
        $path = $this->storageService->uploadFile($file, 'file', Str::orderedUuid());
        dd($path);

        return back();
    }
}
