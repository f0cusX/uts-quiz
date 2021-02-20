<?php

namespace App\Controller\Search\Request;

use App\Api\SearchRequest;
use App\Entity\SearchRequest as SearchRequestEntity;
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
     * @Route("/api/v1/search_requests/{id}", requirements={"id": "\d+"}, methods={"get"}, name="search_request_get")
     * @param SearchRequestEntity $searchRequest
     * @return Response
     * @throws UnsupportedTransformation
     */
    public function one(SearchRequestEntity $searchRequest): Response
    {
        return new JsonResponse(
            $this->transformer->transform(
                $searchRequest, SearchRequest::class
            )
        );
    }
}