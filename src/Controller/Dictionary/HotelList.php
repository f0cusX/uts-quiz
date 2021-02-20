<?php

namespace App\Controller\Dictionary;

use App\Api\DefaultSort;
use App\Api\Hotel;
use App\Api\Page;
use App\Entity\City;
use App\Repository\HotelRepository;
use App\Service\Api\DataTransformer;
use App\Utils\ContentRangeHeader;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class HotelList
{
    /**
     * @var HotelRepository
     */
    private $repository;
    /**
     * @var DataTransformer
     */
    private $dataTransformer;

    /**
     * HotelController constructor.
     * @param HotelRepository $repository
     * @param DataTransformer $dataTransformer
     */
    public function __construct(HotelRepository $repository, DataTransformer $dataTransformer)
    {
        $this->repository = $repository;
        $this->dataTransformer = $dataTransformer;
    }

    /**
     * @Route("/api/v1/countries/{country}/cities/{city}/hotels", requirements={"country": "\d+", "city": "\d+"}, methods={"get"}, name="get_hotels")
     * @param int $country
     * @param City $city
     * @param Page $page
     * @param DefaultSort $sort
     * @return Response
     */
    public function __invoke(int $country, City $city, Page $page, DefaultSort $sort): Response
    {
        if ($city->getCountry()->getId() !== $country) {
            throw new NotFoundHttpException('Not found');
        }

        $paginator = $this->repository->getPage(
            $city,
            $page->number,
            $page->size,
            $sort->property,
            $sort->order
        );

        return new JsonResponse(
            $this->dataTransformer->transformCollection(
                $paginator, Hotel::class
            ),
            JsonResponse::HTTP_OK,
            [
                'Content-Range' => ContentRangeHeader::getContentRangeHeader(
                    $page->number,
                    $page->size,
                    count($paginator)
                )
            ]
        );
    }
}
