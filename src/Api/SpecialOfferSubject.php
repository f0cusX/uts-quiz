<?php

namespace App\Api;

use App\Validator\Constraints\ExistsEntity;
use Symfony\Component\Validator\Constraints as Assert;

class SpecialOfferSubject
{
    const COUNTRY = 'COUNTRY';
    const CITY = 'CITY';
    const HOTEL = 'HOTEL';

    private const ENTITY_CLASSES = [
        self::COUNTRY => \App\Entity\Country::class,
        self::CITY => \App\Entity\City::class,
        self::HOTEL => \App\Entity\Hotel::class
    ];

    /**
     * @Assert\NotBlank()
     * @Assert\Choice({self::COUNTRY,self::CITY,self::HOTEL})
     * @var string
     */
    private $type;
    /**
     * @Assert\NotBlank()
     * @ExistsEntity(callback="getEntityClass")
     * @var int
     */
    private $id;
    /**
     * SpecialOfferSubject constructor.
     * @param string $type
     * @param int $id
     */
    public function __construct(string $type, int $id)
    {
        $this->type = $type;
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function getEntityClass(): ?string
    {
        return self::ENTITY_CLASSES[$this->type] ?? null;
    }
}