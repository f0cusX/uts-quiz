<?php

namespace App\Controller\Search\Request;

use App\Api\CreateSearchRequest;
use App\Entity\SearchRequest;
use App\Exception\UnsupportedTransformation;
use App\Service\Api\DataTransformer;
use App\Service\Searcher;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class Create
{
    /**
     * @var EntityManagerInterface
     */
    private $doctrine;
    /**
     * @var DataTransformer
     */
    private $transformer;
    /**
     * @var Searcher
     */
    private $searcher;

    /**
     * Create constructor.
     * @param EntityManagerInterface $doctrine
     * @param DataTransformer $transformer
     * @param Searcher $searcher
     */
    public function __construct(EntityManagerInterface $doctrine, DataTransformer $transformer, Searcher $searcher)
    {
        $this->doctrine = $doctrine;
        $this->transformer = $transformer;
        $this->searcher = $searcher;
    }

    /**
     * @Route("/api/v1/search_requests", methods={"post"}, name="search_request_create")
     *
     * @param CreateSearchRequest $csr
     * @return Response
     * @throws UnsupportedTransformation
     */
    public function __invoke(CreateSearchRequest $csr): Response
    {
        $entity = $this->transformer->transform($csr, SearchRequest::class);
        $this->doctrine->persist($entity);
        foreach ($this->searcher->search($entity) as $result) {
            dd($result);
            $this->doctrine->persist($result);
        }
        $this->doctrine->flush();

        return new JsonResponse(
            ['id' => $entity->getId()],
            Response::HTTP_CREATED
        );
    }
}
