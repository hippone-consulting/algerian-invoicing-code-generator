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

    /**
     * CodeComponents constructor.
     * @param string $sequentialNumber
     * @param DateTimeImmutable $year
     */
    private function __construct(string $sequentialNumber, DateTimeImmutable $year)
    {
        $this->sequentialNumber = $sequentialNumber;
        $this->year = $year;
    }

    /**
     * @param string $sequentialNumber
     * @param DateTimeImmutable $year
     * @return static
     */
    public static function from(string $sequentialNumber, DateTimeImmutable $year): self
    {
        return new CodeComponents($sequentialNumber, $year);
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