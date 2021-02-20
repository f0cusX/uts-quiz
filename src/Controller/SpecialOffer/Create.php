<?php

namespace App\Controller\SpecialOffer;

use App\Api\CreateSpecialOffer;
use App\Entity\SpecialOffer;
use App\Exception\UnsupportedTransformation;
use App\Service\Api\DataTransformer;
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
     * Create constructor.
     * @param EntityManagerInterface $doctrine
     * @param DataTransformer $transformer
     */
    public function __construct(EntityManagerInterface $doctrine, DataTransformer $transformer)
    {
        $this->doctrine = $doctrine;
        $this->transformer = $transformer;
    }

    /**
     * @Route("/api/v1/special_offers", methods={"post"}, name="special_offer_create")
     *
     * @param CreateSpecialOffer $cso
     * @return Response
     * @throws UnsupportedTransformation
     */
    public function __invoke(CreateSpecialOffer $cso): Response
    {
        $entity = $this->transformer->transform($cso, SpecialOffer::class);
        $this->doctrine->persist($entity);
        $this->doctrine->flush();

        return new JsonResponse(
            ['id' => $entity->getId()],
            Response::HTTP_CREATED
        );
    }
}