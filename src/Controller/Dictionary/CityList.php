<?php

namespace App\Controller\Dictionary;

use App\Api\City;
use App\Api\DefaultSort;
use App\Api\Page;
use App\Entity\Country;
use App\Repository\CityRepository;
use App\Service\Api\DataTransformer;
use App\Utils\ContentRangeHeader;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CityList
{
    /**
     * @var CityRepository
     */
    private $repository;
    /**
     * @var DataTransformer
     */
    private $dataTransformer;

    /**
     * CityList constructor.
     * @param CityRepository $repository
     * @param DataTransformer $dataTransformer
     */
    public function __construct(CityRepository $repository, DataTransformer $dataTransformer)
    {
        $this->repository = $repository;
        $this->dataTransformer = $dataTransformer;
    }

    /**
     * @Route("/api/v1/countries/{country}/cities", requirements={"country": "\d+"}, methods={"get"}, name="get_cities")
     * @param Country $country
     * @param Page $page
     * @param DefaultSort $sort
     * @return Response
     */
    public function __invoke(Country $country, Page $page, DefaultSort $sort): Response
    {
        $paginator = $this->repository
            ->getPage(
                $country,
                $page->number,
                $page->size,
                $sort->property,
                $sort->order
            )
        ;
        return new JsonResponse(
            $this->dataTransformer->transformCollection(
                $paginator, City::class
            ),
            JsonResponse::HTTP_OK,
            ['Content-Range' => ContentRangeHeader::getContentRangeHeader(
                $page->number, $page->size, count($paginator)
            )]
        );
    }
}
