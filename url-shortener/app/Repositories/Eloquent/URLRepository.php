<?php

namespace App\Repositories\Eloquent;

use Carbon\Carbon;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Collection;
use App\Repositories\Contracts\URLRepositoryInterface;


class URLRepository implements URLRepositoryInterface
{
    protected $expirationTime = 1800;

    /**
     * Generates a shortened URL by creating a unique short ID,
     * storing the original URL and click count in Redis,
     * setting an expiration time.
     * Returns an array with the short ID, original URL, expiration time, and click count.
     *
     * @param string $url The original URL to shorten.
     * @return array Contains short ID, original URL, expiration time, and click count.
     */
    public function create(string $url): array
    {

        $shortId = substr(md5($url . time()), 0, 6);
        Redis::setex("short_url:$shortId", $this->expirationTime, $url);
        Redis::set("click_count:$shortId", 0);

        return [
            'short_id' => $shortId,
            'original_url'  => $this->findOriginalUrl($shortId),
            'expires_in'    => $this->getHumanReadableTtl($shortId),
            'click_count'          => $this->getClickCount($shortId),

        ];
    }

    /**
     * Retrieves the original URL from Redis using the provided short ID.
     *
     * @param string $shortId The shortened URL's ID.
     * @return string|null The original URL, or null if not found.
     */
    public function findOriginalUrl(string $shortId): ?string
    {
        return Redis::get("short_url:$shortId");
    }

    /**
     * Increments the click count for the given short ID in Redis.
     *
     * @param string $shortId The shortened URL's ID.
     * @return int The updated click count.
     */
    public function incrementClickCount(string $shortId): ?int
    {
        return Redis::incr("click_count:$shortId");
    }

    /**
     * Retrieves the click count for the given short ID from Redis.
     *
     * @param string $shortId The shortened URL's ID.
     * @return string|null The current click count, or null if not found.
     */
    public function getClickCount(string $shortId): ?string
    {
        return Redis::get("click_count:$shortId");
    }


    /**
     * Fetches all shortened URLs from Redis and returns their details as a collection.
     *
     * @return \Illuminate\Support\Collection A collection of objects containing the short ID, original URL, click count, and expiration time.
     */
    public function fetchShortenedUrls(): Collection
    {
        $data = [];
        $keys = Redis::keys('short_url:*');

        if (empty($keys)) {
            return collect($data);
        }
        foreach ($keys as $key) {

            $shortId = str_replace('laravel_database_short_url:', '', $key);

            $data[] = (object) [
                'short_id'     => $shortId,
                'original_url'  => $this->findOriginalUrl($shortId),
                'click_count'          => $this->getClickCount($shortId),
                'expires_in'    => $this->getHumanReadableTtl($shortId),
            ];
        }
        return collect($data);
    }

    /**
     * Gets the human-readable expiration time for the given short ID.
     * Returns "Expired" if the URL has already expired.
     *
     * @param string $shortId The shortened URL's ID.
     * @return string The human-readable expiration time, or "Expired" if the URL has expired.
     */
    private function getHumanReadableTtl(string $shortId): string
    {
        $expiresIn = Redis::ttl("short_url:$shortId");

        return $expiresIn > 0
            ? Carbon::now()->addSeconds($expiresIn)->diffForHumans()
            : 'Expired';
    }
}
