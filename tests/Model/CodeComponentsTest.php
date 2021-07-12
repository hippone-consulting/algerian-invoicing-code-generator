<?php
declare(strict_types=1);

namespace Hippone\InvoiceCode\Test\Model;

use DateTimeImmutable;
use DateTimeZone;
use Hippone\InvoiceCode\Model\CodeComponents;
use PHPUnit\Framework\TestCase;

class CodeComponentsTest extends TestCase
{
    /** @test */
    function it_generates_sequential_number_with_3_left_zeros_for_numbers_less_than_ten()
    {
        $components = CodeComponents::from(
            1,
            DateTimeImmutable::createFromFormat('Y', '2021', new DateTimeZone('Africa/Algiers'))
        );

        $components2 = CodeComponents::from(
            9,
            DateTimeImmutable::createFromFormat('Y', '2021', new DateTimeZone('Africa/Algiers'))
        );

        self::assertEquals('0001/2021', $components->toString());
        self::assertEquals('0009/2021', $components2->toString());
    }

    /** @test */
    function it_generates_sequential_number_with_2_left_zeros_for_numbers_less_than_100()
    {
        $components = CodeComponents::from(
            10,
            DateTimeImmutable::createFromFormat('Y', '2021', new DateTimeZone('Africa/Algiers'))
        );

        $components2 = CodeComponents::from(
            99,
            DateTimeImmutable::createFromFormat('Y', '2021', new DateTimeZone('Africa/Algiers'))
        );

        self::assertEquals('0010/2021', $components->toString());
        self::assertEquals('0099/2021', $components2->toString());
    }

    /** @test */
    function it_generates_sequential_number_with_1_left_zeros_for_numbers_less_than_1000()
    {
        $components = CodeComponents::from(
            100,
            DateTimeImmutable::createFromFormat('Y', '2021', new DateTimeZone('Africa/Algiers'))
        );

        $components2 = CodeComponents::from(
            999,
            DateTimeImmutable::createFromFormat('Y', '2021', new DateTimeZone('Africa/Algiers'))
        );

        self::assertEquals('0100/2021', $components->toString());
        self::assertEquals('0999/2021', $components2->toString());
    }

    /** @test */
    function it_generates_sequential_number_without_left_zeros_when_sequential_equal_or_superior_to_1000()
    {
        $components = CodeComponents::from(
            1000,
            DateTimeImmutable::createFromFormat('Y', '2021', new DateTimeZone('Africa/Algiers'))
        );

        $components2 = CodeComponents::from(
            9999,
            DateTimeImmutable::createFromFormat('Y', '2021', new DateTimeZone('Africa/Algiers'))
        );

        self::assertEquals('1000/2021', $components->toString());
        self::assertEquals('9999/2021', $components2->toString());
    }
}