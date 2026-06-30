<?php

declare(strict_types=1);

namespace DualMedia\DtoRequestBundle\Metadata\Model;

readonly class Format
{
    /**
     * @param non-empty-string $format
     * @param string|null      $time   normalized `H:i:s` time-of-day, or `null` to leave the parsed time untouched
     *
     * @throws \InvalidArgumentException when `$time` is not a valid `H:i:s` value
     */
    public function __construct(
        public string $format,
        public string|null $time = null
    ) {
        if (null !== $time) {
            $parsed = \DateTimeImmutable::createFromFormat('!H:i:s', $time);
            $errors = \DateTimeImmutable::getLastErrors();

            if (false === $parsed
                || (false !== $errors && ($errors['warning_count'] > 0 || $errors['error_count'] > 0))
            ) {
                throw new \InvalidArgumentException(sprintf(
                    'Invalid time "%s" passed to #[Format], expected an "H:i:s" time-of-day.',
                    $time
                ));
            }
        }
    }
}
