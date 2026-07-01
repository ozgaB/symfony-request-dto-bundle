<?php

declare(strict_types=1);

namespace DualMedia\DtoRequestBundle\Metadata\Model;

readonly class Format
{
    /**
     * @param non-empty-string   $format
     * @param \DateInterval|null $time   time-of-day (as an offset from midnight) applied after a
     *                                   successful parse, or `null` to leave the parsed time untouched
     */
    public function __construct(
        public string $format,
        public \DateInterval|null $time = null
    ) {
    }
}
