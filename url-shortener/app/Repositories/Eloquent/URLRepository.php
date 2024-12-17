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
