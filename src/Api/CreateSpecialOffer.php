<?php

namespace App\Api;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class SpecialOffer
 * @package App\Api
 */
class CreateSpecialOffer
{
    /**
     * @Assert\NotBlank()
     * @Assert\Valid()
     * @var SpecialOfferSubject
     */
    private $subject;
    /**
     * @Assert\NotBlank()
     * @var string
     */
    private $description;
    /**
     * @Assert\NotBlank()
     * @Assert\Valid()
     * @var Discount
     */
    private $discount;

    /**
     * CreateSpecialOffer constructor.
     * @param SpecialOfferSubject $subject
     * @param string $description
     * @param Discount $discount
     */
    public function __construct(SpecialOfferSubject $subject, string $description, Discount $discount)
    {
        $this->subject = $subject;
        $this->description = $description;
        $this->discount = $discount;
    }

    /**
     * @return SpecialOfferSubject
     */
    public function getSubject(): SpecialOfferSubject
    {
        return $this->subject;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return Discount
     */
    public function getDiscount(): Discount
    {
        return $this->discount;
    }
}
