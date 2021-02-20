<?php

namespace App\Middleware;

use App\Api\DefaultSort;
use App\Api\PricingSort;
use App\Exception\ValidationException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SortParamConverter implements ParamConverterInterface
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * RequestContentParamConverter constructor.
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function apply(Request $request, ParamConverter $configuration)
    {
        $class = $configuration->getClass();
        $sort = new $class();
        $params = $request->query->get('sort');
        if ($params) {
            $sort->property = $params['property'] ?? $sort->property;
            $sort->order = $params['order'] ?? $sort->order;
            $violations = $this->validator->validate($sort);
            if ($violations->count()) {
                throw ValidationException::fromViolations($violations);
            }
        }
        $request->attributes->set($configuration->getName(), $sort);
        return true;
    }

    public function supports(ParamConverter $configuration)
    {
        $class = $configuration->getClass();
        return in_array($class, [DefaultSort::class, PricingSort::class]);
    }
}