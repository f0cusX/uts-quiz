<?php


namespace App\Api;

use JsonSerializable;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Discount as D;

/**
 * Class Money
 * @package App\Api
 */
class Discount implements JsonSerializable
{
    /**
     * @Assert\NotBlank()
     * @Assert\Choice({D::TYPE_ABSOLUTE,D::TYPE_MULTIPLE})
     * @var string
     */
    private $type;
    /**
     * @Assert\NotBlank()
     * @var int
     */
    private $value;

    /**
     * Discount constructor.
     * @param string $type
     * @param int $value
     */
    public function __construct(string $type, int $value)
    {
        $this->type = $type;
        $this->value = $value;
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
    public function getValue(): int
    {
        return $this->value;
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}