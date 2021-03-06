<?php

namespace App\Service;

use App\Entity\SearchRequest;
use App\Entity\SearchResult;
use App\Repository\CurrencyRepository;
use App\Repository\HotelRepository;
use App\Repository\MealRepository;

class Searcher
{
    /**
     * @var ProviderInterface
     */
    private $offerProvider;
    /**
     * @var HotelRepository
     */
    private $hotelRepository;
    /**
     * @var MealRepository
     */
    private $mealRepository;
    /**
     * @var CurrencyRepository
     */
    private $currencyRepository;

    /**
     * Searcher constructor.
     * @param ProviderInterface $offerProvider
     * @param HotelRepository $hotelRepository
     * @param MealRepository $mealRepository
     * @param CurrencyRepository $currencyRepository
     */
    public function __construct(ProviderInterface $offerProvider, HotelRepository $hotelRepository, MealRepository $mealRepository, CurrencyRepository $currencyRepository)
    {
        $this->offerProvider = $offerProvider;
        $this->hotelRepository = $hotelRepository;
        $this->mealRepository = $mealRepository;
        $this->currencyRepository = $currencyRepository;
    }

    public function search(SearchRequest $request): array
    {
        $offers = $this->offerProvider->search($request);
        if (empty($offers)) {
            return [];
        }

        $hotelIds = [];
        $mealIds = [];
        foreach ($offers as $offer) {
            $hotelIds[$offer->getHotel()] = true;
            if ($mealId = $offer->getMeal()) {
                $mealIds[$mealId] = true;
            }
        }
        unset($offer);
        $hotels = $this->hotelRepository->findByIds(array_keys($hotelIds));
        $meals = $this->mealRepository->findByIds(array_keys($mealIds));
        $currencies = $this->currencyRepository->findAllRatesIndexById();

        $results = [];
        foreach ($offers as $offer) {
            $price = $offer->getPrice();
            if (
                !($currencyRate = $currencies[$price->getCurrency()] ?? null) ||
                !($hotel = $hotels[$offer->getHotel()] ?? null)
            ) {
                continue;
            }
            $results[] = (new SearchResult())
                ->setPrice($offer->getPrice())
                ->setRequest($request)
                ->setMeal($meals[$offer->getMeal()] ?? null)
                ->setHotel($hotel)
                ->setRoomName($offer->getRoomName())
                ->setComparePrice(intval($price->getAmount() * $currencyRate))
            ;
        }

        return $results;
    }
}