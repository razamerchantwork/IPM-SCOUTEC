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
   //resolve url
   public function resolve(string $shortId)
   {
       try {
           $urlData = $this->urlShortenerService->resolveUrl($shortId);

           if (!$urlData) {
               throw new \Exception('URL not found or expired');
           }
           return redirect()->to($urlData['url']);
       } catch (\Exception $e) {
           return view('error.url-not-found', ['message' => $e->getMessage()]);
       }
   }


    // Fetch all URLs
    public function fetchShortenedUrls()
    {
        try {
            $urls = $this->urlShortenerService->fetchShortenedUrls();
            if ($urls->isEmpty()) {
                return successResponse([], 'No URLs found.');
            }
            return successResponse(ShortUrlResource::collection($urls), 'URLs fetched successfully.');
        } catch (\Exception $e) {
            return errorResponse($e->getMessage(), $e->getCode());
        }
    }
}
