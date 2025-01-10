<?php

namespace DualMedia\DtoRequestBundle\Traits\Type;

use DualMedia\DtoRequestBundle\Model\Type\CoerceResult;
use DualMedia\DtoRequestBundle\Model\Type\Property;
use DualMedia\DtoRequestBundle\Util;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @template T
 */
trait CoercerResultTrait
{
    /**
     * @param T|list<T> $value
     * @param Constraint[] $constraints
     *
     * @return CoerceResult<T>
     */
    private function buildResult(
        ValidatorInterface $validator,
        string $propertyPath,
        Property $property,
        mixed $value,
        array $constraints,
    ): CoerceResult {
        if ($property->isCollection()) {
            $constraints = [
                new All([
                    'constraints' => $constraints,
                ]),
            ];
        }

        $violations = $validator->startContext()
            ->atPath($propertyPath)
            ->validate($value, $constraints)
            ->getViolations();

        if (!$property->isCollection()) {
            return new CoerceResult(
                0 === $violations->count() ? $value : null,
                $violations
            );
        }

        /** @var ConstraintViolationInterface $violation */
        foreach ($violations as $violation) {
            Util::removeIndexByConstraintViolation($value, $propertyPath, $violation);
        }

        return new CoerceResult(
            $value,
            $violations
        );
    }
}
