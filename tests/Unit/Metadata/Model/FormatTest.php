<?php

declare(strict_types=1);

namespace DualMedia\DtoRequestBundle\Tests\Unit\Metadata\Model;

use DualMedia\DtoRequestBundle\Dto\Enum\Time;
use DualMedia\DtoRequestBundle\Metadata\Model\Format;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;

#[CoversClass(Format::class)]
#[Group('unit')]
class FormatTest extends TestCase
{
    public function testNullTimeIsAllowed(): void
    {
        $format = new Format('Y-m-d');
        static::assertNull($format->time);
    }

    /**
     * @return iterable<string, array{string}>
     */
    public static function provideValidTimeIsAcceptedCases(): iterable
    {
        yield 'start of day' => [Time::StartOfDay->value];
        yield 'midday' => [Time::Midday->value];
        yield 'end of day' => [Time::EndOfDay->value];
        yield 'custom' => ['06:30:15'];
    }

    #[DataProvider('provideValidTimeIsAcceptedCases')]
    public function testValidTimeIsAccepted(
        string $time
    ): void {
        $format = new Format('Y-m-d', $time);
        static::assertSame($time, $format->time);
    }

    /**
     * @return iterable<string, array{string}>
     */
    public static function provideInvalidTimeThrowsCases(): iterable
    {
        yield 'out of range hour' => ['25:00:00'];
        yield 'out of range minute' => ['10:99:00'];
        yield 'missing seconds' => ['10:30'];
        yield 'not a time' => ['nonsense'];
        yield 'empty' => [''];
    }

    #[DataProvider('provideInvalidTimeThrowsCases')]
    public function testInvalidTimeThrows(
        string $time
    ): void {
        $this->expectException(\InvalidArgumentException::class);

        new Format('Y-m-d', $time);
    }
}
