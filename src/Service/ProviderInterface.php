<?php

namespace App\Service;

use App\Entity\ProviderOffer;
use App\Entity\SearchRequest;

interface ProviderInterface
{
    /**
     * @param SearchRequest $searchRequest
     * @return ProviderOffer[]
     */
    public function search(SearchRequest $searchRequest): array;
}