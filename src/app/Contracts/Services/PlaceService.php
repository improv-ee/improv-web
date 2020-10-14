<?php

namespace App\Contracts\Services;

use Illuminate\Support\Collection;

interface PlaceService
{
    public function searchByName(string $name, array $args = []): Collection;

    public function getPlaceDetails(string $uid, array $args = []): array;

    public function getStaticPlaceImageUrl(string $address, string $name) : string;
}
