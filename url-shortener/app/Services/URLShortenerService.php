<?php

namespace App\Services;

use App\Repositories\Contracts\URLRepositoryInterface;

class URLShortenerService
{
    protected $urlRepository;

    public function __construct(URLRepositoryInterface $urlRepository)
    {
        $this->urlRepository = $urlRepository;
    }



    public function createShortenUrl(string $url): array
    {
        return $this->urlRepository->create($url);
    }

    public function resolveUrl(string $shortId): ?array
    {
        $url = $this->urlRepository->findOriginalUrl($shortId);

        if ($url) {
            $this->urlRepository->incrementClickCount($shortId);
            return [
                "url" => $url,
            ];
        }

        return null;
    }

    public function fetchShortenedUrls()
    {
       return $this->urlRepository->fetchShortenedUrls();
    }
}
