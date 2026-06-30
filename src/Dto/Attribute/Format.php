<?php

declare(strict_types=1);

namespace DualMedia\DtoRequestBundle\Dto\Attribute;

use DualMedia\DtoRequestBundle\Dto\Enum\Time;

/**
 * DateTime format specifier for date parsing.
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
readonly class Format
{
    /**
     * @param non-empty-string      $format
     * @param Time|string|null $time   optional time-of-day (`H:i:s`) applied after a successful parse;
     *                                      `null` leaves the parsed time untouched
     */
    public function __construct(
        public string $format,
        public Time|string|null $time = null
    ) {
    }
}
