<?php

namespace App\Middleware;

use App\Api\Page;
use App\Exception\ValidationException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PageParamConverter implements ParamConverterInterface
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
        $page = new Page();
        $params = $request->query->get('page');
        if ($params) {
            $page->number = intval($params['number'] ?? $page->number);
            $page->size = intval($params['size'] ?? $page->size);
            $violations = $this->validator->validate($page);
            if ($violations->count()) {
                throw ValidationException::fromViolations($violations);
            }
        }
        $request->attributes->set($configuration->getName(), $page);
        return true;
    }

    public function supports(ParamConverter $configuration)
    {
        return $configuration->getClass() === Page::class;
    }
}