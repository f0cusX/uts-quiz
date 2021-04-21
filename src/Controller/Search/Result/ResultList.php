<?php

namespace App\Controller\Search\Result;

use App\Api\Page;
use App\Api\PricingSort;
use App\Api\SearchResult;
use App\Entity\SearchRequest;
use App\Repository\SearchResultRepository;
use App\Service\Api\DataTransformer;
use App\Utils\ContentRangeHeader;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ResultList
{
    /**
     * @var SearchResultRepository
     */
    private $repository;
    /**
     * @var DataTransformer
     */
    private $transformer;

    /**
     * ResultList constructor.
     * @param SearchResultRepository $repository
     * @param DataTransformer $transformer
     */
    public function __construct(SearchResultRepository $repository, DataTransformer $transformer)
    {
        $this->repository = $repository;
        $this->transformer = $transformer;
    }

    /**
     * @Route("/api/v2/search_requests/{searchRequest}/results", requirements={"searchRequest": "\d+"}, methods={"get"}, name="search_results_list")
     * @param SearchRequest $searchRequest
     * @param Page $page
     * @param PricingSort $sort
     * @return Response
     */
    public function __invoke(SearchRequest $searchRequest, Page $page, PricingSort $sort): Response
    {
        $paginator = $this->repository->getPage(
            $searchRequest,
            $page->number,
            $page->size,
            $sort->property,
            $sort->order
        );

        return new JsonResponse(
            $this->transformer->transformCollection(
                $paginator, SearchResult::class
            ),
            JsonResponse::HTTP_OK,
            ['Content-Range' => ContentRangeHeader::getContentRangeHeader(
                $page->number, $page->size, count($paginator)
            )]
        );
    }
}
