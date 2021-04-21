<?php

namespace App\Entity;

use App\Repository\SearchResultRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SearchResultRepository::class)
 * @ORM\Table(indexes={
 *      @ORM\Index(columns="compare_price", name="search_result_compare")
 * })
 */
class SearchResult
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=SearchRequest::class)
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $request;

    /**
     * @ORM\ManyToOne(targetEntity=Hotel::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $hotel;

    /**
     * @ORM\ManyToOne(targetEntity=Meal::class)
     */
    private $meal;

    /**
     * @ORM\Column(name="room_name")
     * @var string
     */
    private $roomName;

    /**
     * @ORM\Embedded(class=Money::class)
     * Money
     */
    private $price;

    /**
     * @ORM\Column(name="compare_price", type="integer")
     * @var int
     */
    private $comparePrice;

    /**
     * @ORM\ManyToOne(targetEntity=SpeacialOffer::class)
     * @ORM\JoinColumn(nullable=true)
     */
    private $specialOffer;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRequest(): ?SearchRequest
    {
        return $this->request;
    }

    public function setRequest(SearchRequest $request): self
    {
        $this->request = $request;

        return $this;
    }

    public function getHotel(): ?Hotel
    {
        return $this->hotel;
    }

    public function setHotel(Hotel $hotel): self
    {
        $this->hotel = $hotel;

        return $this;
    }

    public function getMeal(): ?Meal
    {
        return $this->meal;
    }

    public function setMeal(Meal $meal): self
    {
        $this->meal = $meal;

        return $this;
    }

    public function getPrice(): ?Money
    {
        return $this->price;
    }

    public function setPrice(Money $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getRoomName(): ?string
    {
        return $this->roomName;
    }

    public function setRoomName(string $roomName): self
    {
        $this->roomName = $roomName;

        return $this;
    }

    /**
     * @return int
     */
    public function getComparePrice(): int
    {
        return $this->comparePrice;
    }

    /**
     * @param int $comparePrice
     * @return SearchResult
     */
    public function setComparePrice(int $comparePrice): self
    {
        $this->comparePrice = $comparePrice;

        return $this;
    }

    public function setSpecialOffer(SpecialOffer $specialOffer): self
    {
        $this->specialOffer = $specialOffer;

        return $this;
    }

    public function getSpecialOffer(): ?SpecialOffer
    {
        return $this->specialOffer;
    }
}
