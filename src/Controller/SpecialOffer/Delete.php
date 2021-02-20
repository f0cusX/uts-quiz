<?php


namespace App\Controller\SpecialOffer;


use App\Entity\SpecialOffer;
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
     * @Route("/api/v1/special_offers/{offer}", requirements={"offer": "\d+"}, methods={"delete"}, name="special_offer_delete")
     * @param SpecialOffer $offer
     * @return Response
     */
    public function __invoke(SpecialOffer $offer): Response
    {
        $this->doctrine->remove($offer);
        $this->doctrine->flush();

        return new Response('', Response::HTTP_NO_CONTENT);
    }
}