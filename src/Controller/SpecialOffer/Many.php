<?php

namespace App\Controller\SpecialOffer;

use App\Api\SpecialOffer;
use App\Repository\SpecialOfferRepository;
use App\Service\Api\DataTransformer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Many
{
    /**
     * @var DataTransformer
     */
    private $transformer;
    /**
     * @var SpecialOfferRepository
     */
    private $repository;

    /**
     * Many constructor.
     * @param DataTransformer $transformer
     * @param SpecialOfferRepository $repository
     */
    public function __construct(DataTransformer $transformer, SpecialOfferRepository $repository)
    {
        $this->transformer = $transformer;
        $this->repository = $repository;
    }
    /**
     * @Route("/api/v1/special_offers", methods={"get"}, name="special_offer_list")
     */
    public function __invoke(): Response
    {
        return new JsonResponse(
            $this->transformer->transformCollection(
                $this->repository->findAll(), SpecialOffer::class
            )
        );
    }
}