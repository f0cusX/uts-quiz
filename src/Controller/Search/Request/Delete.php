<?php


namespace App\Controller\Search\Request;


use App\Entity\SearchRequest;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Delete
{
    /**
     * @var EntityManagerInterface
     */
    private $doctrine;

    /**
     * Delete constructor.
     * @param EntityManagerInterface $doctrine
     */
    public function __construct(EntityManagerInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @Route("/api/v1/search_requests/{id}", requirements={"id": "\d+"}, methods={"delete"}, name="search_request_delete")
     * @param SearchRequest $searchRequest
     * @return Response
     */
    public function __invoke(SearchRequest $searchRequest): Response
    {
        $this->doctrine->remove($searchRequest);
        $this->doctrine->flush();

        return new Response('', Response::HTTP_NO_CONTENT);
    }
}