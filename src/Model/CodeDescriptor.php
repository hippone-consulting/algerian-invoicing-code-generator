<?php
declare(strict_types=1);

namespace Hippone\InvoiceCode\Model;

use DateTimeImmutable;

/**
 * Class CodeDescriptor
 * @package Hippone\InvoiceCode\Model
 */
final class CodeDescriptor
{
    private string $sequentialNumber;
    private DateTimeImmutable $year;

    public function __construct(string $sequentialNumber, DateTimeImmutable $year)
    {
        $this->sequentialNumber = $sequentialNumber;
        $this->year = $year;
    }

    /**
     * @return string
     */
    public function sequentialNumber(): string
    {
        return $this->sequentialNumber;
    }

    /**
     * @return DateTimeImmutable
     */
    public function year(): DateTimeImmutable
    {
        return $this->year;
    }

    /**
     * @return string
     */
    public function formatted(): string
    {
        return sprintf('%s/%s', $this->sequentialNumber, $this->year->format('Y'));
    }
}