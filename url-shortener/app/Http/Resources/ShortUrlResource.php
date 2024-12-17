<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShortUrlResource extends JsonResource
{
    public function toArray(Request $request)

    {
        return [
            'short_id'     => $this->short_id ?? null,
            'short_url'    => isset($this->short_id) ? url("{$this->short_id}") : null,
            'original_url' => $this->original_url ?? null,
            'click_count'         => (int)$this->click_count ?? 0,
            'expires_in'   => $this->expires_in ?? 'N/A',
        ];
    }
}
