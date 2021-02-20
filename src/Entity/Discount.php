<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Money
 * @package App\Entity
 * @ORM\Embeddable()
 */
class Discount
{
    const TYPE_ABSOLUTE = 'A';
    const TYPE_MULTIPLE = 'M';

    /**
     * @ORM\Column(length=1)
     * @var string
     */
    private $type;
    /**
     * @ORM\Column(type="integer")
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
}