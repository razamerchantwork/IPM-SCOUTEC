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

}
