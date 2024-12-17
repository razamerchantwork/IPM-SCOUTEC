<?php
namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface URLRepositoryInterface
{
    public function create(string $url): array;

    public function findOriginalUrl(string $shortId): ?string;

    public function incrementClickCount(string $shortId): ?int;

    public function fetchShortenedUrls(): Collection;
}
