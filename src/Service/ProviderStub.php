<?php

namespace App\Service;

use App\Entity\Money;
use App\Entity\ProviderOffer;
use App\Entity\SearchRequest;
use App\Repository\CurrencyRepository;

/**
 * Class ProviderStub
 * @package App\Service
 * @deprecated Не использовать, не менять. Это "заглушка" имитирующая сторонний сервис
 */
class ProviderStub implements ProviderInterface
{
    /**
     * @var string
     */
    private $dataDirectory;
    /**
     * @var CurrencyRepository
     */
    private $currencyRepository;

    /**
     * ProviderStub constructor.
     * @param string $dataDirectory
     * @param CurrencyRepository $currencyRepository
     */
    public function __construct(string $dataDirectory, CurrencyRepository $currencyRepository)
    {
        $this->dataDirectory = $dataDirectory;
        $this->currencyRepository = $currencyRepository;
    }

    public function search(SearchRequest $searchRequest): array
    {
        $cityId = $searchRequest->getCity()->getId();
        $file = $this->dataDirectory . DIRECTORY_SEPARATOR . $cityId . '.json';
        if (!file_exists($file)) {
            return [];
        }
        $data = json_decode(file_get_contents($file));
        $diff = $searchRequest->getCheckIn()->diff($searchRequest->getCheckOut());
        $duration = $diff->days;
        $results = [];
        $rates = $this->currencyRepository->findAllRatesIndexById();
        foreach ($data as $item) {
            $currency = $item->price->currency;
            $amount = $item->price->amount;
            if ($currency === 'RUB') {
                $currency = array_rand($rates);
                $amount = round($amount / $rates[$currency], 2);
            }
            $results[] = new ProviderOffer(
                $item->hotel,
                $item->roomName,
                new Money($amount * $duration, $currency),
                $item->meal
            );
        }

        return $results;
    }
}