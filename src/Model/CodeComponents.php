<?php
declare(strict_types=1);

namespace Hippone\InvoiceCode\Model;

use DateTimeImmutable;

/**
 * Class CodeComponents
 * @package Hippone\InvoiceCode\Model
 */
final class CodeComponents
{
    /**
     * @var string
     */
    private string $sequentialNumber;

    /**
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $year;

    private function __construct()
    {
    }

    /**
     * @param string $sequentialNumber
     * @param DateTimeImmutable $year
     * @return static
     */
    public static function from(int $sequentialNumber, DateTimeImmutable $year): self
    {
        $instance = new CodeComponents();
        $sequentialNumberStr = $instance->normalizeSequentialNumber($sequentialNumber);
        $instance->sequentialNumber = $sequentialNumberStr;
        $instance->year = $year;
        return $instance;
    }

    private function normalizeSequentialNumber(int $sequentialNumber): string
    {
        $zerosMap = [
            '0' => ['min' => 99, 'max' => 1000],
            '00' => ['min' => 9, 'max' => 100],
            '000' => ['min' => 0, 'max' => 10],
        ];

        foreach ($zerosMap as $howManyZeros => $minMax) {
            if ($sequentialNumber > $minMax['min'] && $sequentialNumber < $minMax['max']) {
                return $howManyZeros . $sequentialNumber;
            }
        }

        return (string) $sequentialNumber;
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return sprintf('%s/%s', $this->sequentialNumber, $this->year->format('Y'));
    }

    /**
     * @return CodeDescriptor
     */
    public function toDescriptor(): CodeDescriptor
    {
        return new CodeDescriptor($this->sequentialNumber, $this->year);
    }
}