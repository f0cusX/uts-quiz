<?php

namespace App\Controller\SpecialOffer;

use App\Api\SpecialOffer;
use App\Entity\SpecialOffer as OfferEntity;
use App\Exception\UnsupportedTransformation;
use App\Service\Api\DataTransformer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class One
{
    /**
     * @var DataTransformer
     */
    private $transformer;

    /**
     * One constructor.
     * @param DataTransformer $transformer
     */
    public function __construct(DataTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    /**
     * @Route("/api/v1/special_offers/{offer}", requirements={"offer": "\d+"}, methods={"get"}, name="special_offer_get")
     * @param OfferEntity $offer
     * @return Response
     * @throws UnsupportedTransformation
     */
    public function one(OfferEntity $offer): Response
    {
        return new JsonResponse(
            $this->transformer->transform(
                $offer, SpecialOffer::class
            )
        );
    }
}