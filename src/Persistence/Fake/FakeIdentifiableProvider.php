<?php
declare(strict_types=1);

namespace Hippone\InvoiceCode\Persistence\Fake;

use DateTimeImmutable;
use Hippone\InvoiceCode\Model\IdentifiableProvider;
use Hippone\InvoiceCode\Model\CodeComponents;

/**
 * Class FakeIdentifiableProvider
 * @package Hippone\InvoiceCode\Persistence\Fake
 */
final class FakeIdentifiableProvider implements IdentifiableProvider
{
    /**
     * @var iterable|array
     */
    private iterable $instances = [];

    /**
     * @param DateTimeImmutable $year
     * @return CodeComponents
     */
    public function nextCode(DateTimeImmutable $year): CodeComponents
    {
        $currentCount = count($this->instances);
        $sequentialNumber = $currentCount + 1;
        return CodeComponents::from($sequentialNumber, $year);
    }
}