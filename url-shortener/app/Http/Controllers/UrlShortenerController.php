<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\URLShortenerService;
use App\Http\Requests\ShortenUrlRequest;
use App\Http\Resources\ShortUrlResource;

class UrlShortenerController extends Controller
{
    protected $urlShortenerService;

    public function __construct(URLShortenerService $urlShortenerService)
    {
        $this->urlShortenerService = $urlShortenerService;
    }

    // create url
    public function createShortenUrl(ShortenUrlRequest $request)
    {
        try {
            $shortURL = $this->urlShortenerService->createShortenUrl($request->validated()['url']);
            return successResponse(new ShortUrlResource((object) $shortURL), 'URL generated Successfully .');
        }
         catch (\Exception $e) {
            return errorResponse($e->getMessage(), $e->getCode());
        }
    }

}
