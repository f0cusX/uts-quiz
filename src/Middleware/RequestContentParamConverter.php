<?php

namespace App\Middleware;

use App\Exception\ValidationException;
use App\Service\Api\DataTransformer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestContentParamConverter implements ParamConverterInterface
{
    /**
     * @var DataTransformer
     */
    private $transformer;
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * RequestContentParamConverter constructor.
     * @param DataTransformer $transformer
     * @param ValidatorInterface $validator
     */
    public function __construct(DataTransformer $transformer, ValidatorInterface $validator)
    {
        $this->transformer = $transformer;
        $this->validator = $validator;
    }

    public function apply(Request $request, ParamConverter $configuration)
    {
        $method = $request->getMethod();
        if (
            !in_array(
                $method,
                [
                    Request::METHOD_POST,
                    Request::METHOD_PUT,
                    Request::METHOD_PATCH
                ]
            ) ||
            ! ($content = $request->getContent())
        ) {
            return false;
        }
        $data = json_decode($content);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new ValidationException(json_last_error_msg());
        }
        $object = $this->transformer->transform($data, $configuration->getClass());
        $violations = $this->validator->validate($object);
        if ($violations->count()) {
            throw ValidationException::fromViolations($violations);
        }

        $request->attributes->set($configuration->getName(), $object);

        return true;
    }

    public function supports(ParamConverter $configuration)
    {
        return substr($configuration->getClass(), 0,7) === 'App\Api';
    }
}