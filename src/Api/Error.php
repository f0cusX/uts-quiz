<?php

namespace App\Api;

use JsonSerializable;

class Error implements JsonSerializable
{
    /**
     * @var int
     */
    protected $code;
    /**
     * @var string
     */
    protected $message;
    /**
     * @var array
     */
    protected $details;

    /**
     * Error constructor.
     * @param int $code
     * @param string $message
     * @param array $details
     */
    public function __construct(int $code, string $message, array $details)
    {
        $this->code = $code;
        $this->message = $message;
        $this->details = $details;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return array
     */
    public function getDetails(): array
    {
        return $this->details;
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}