<?php

namespace App\Controller\Dictionary;

use App\Api\Country;
use App\Api\DefaultSort;
use App\Api\Page;
use App\Repository\CountryRepository;
use App\Service\Api\DataTransformer;
use App\Utils\ContentRangeHeader;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CountryList
{
    /**
     * @var CountryRepository
     */
    private $repository;
    /**
     * @var DataTransformer
     */
    private $dataTransformer;

    /**
     * CountryList constructor.
     * @param CountryRepository $repository
     * @param DataTransformer $dataTransformer
     */
    public function __construct(CountryRepository $repository, DataTransformer $dataTransformer)
    {
        $this->repository = $repository;
        $this->dataTransformer = $dataTransformer;
    }

    /**
     * @Route("/api/v1/countries", methods={"get"}, name="get_countries")
     * @param Page $page
     * @param DefaultSort $sort
     * @return Response
     */
    public function __invoke(Page $page, DefaultSort $sort): Response
    {
        $paginator = $this->repository
            ->getPage(
                $page->number,
                $page->size,
                $sort->property,
                $sort->order
            )
        ;
        return new JsonResponse(
            $this->dataTransformer->transformCollection(
                $paginator, Country::class
            ),
            JsonResponse::HTTP_OK,
            ['Content-Range' => ContentRangeHeader::getContentRangeHeader(
                $page->number, $page->size, count($paginator)
            )]
        );
    }
}
