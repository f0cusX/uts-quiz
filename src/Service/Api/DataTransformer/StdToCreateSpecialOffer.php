<?php


namespace App\Service\Api\DataTransformer;

use App\Api\CreateSpecialOffer;
use App\Api\Discount;
use App\Api\SpecialOfferSubject;
use App\Service\Api\DataTransformer;
use App\Service\Api\DataTransformerInterface;
use LogicException;

class StdToCreateSpecialOffer implements DataTransformerInterface
{
    public function supports($data, string $targetClass): bool
    {
        return get_class($data) === 'stdClass' &&
            $targetClass === CreateSpecialOffer::class;
    }

    /**
     * @inheritDoc
     */
    public function transform($data, string $targetClass, DataTransformer $transformer)
    {
        if (!$this->supports($data, $targetClass)) {
            throw new LogicException('Incorrect workflow');
        }

        $subject = new SpecialOfferSubject(
            $data->subject->type ?? '',
            $data->subject->id ?? 0
        );

        $discount = new Discount(
            $data->discount->type ?? '',
            $data->discount->value ?? 0
        );

        return new CreateSpecialOffer(
            $subject,
            $data->description ?? '',
            $discount
        );
    }
}