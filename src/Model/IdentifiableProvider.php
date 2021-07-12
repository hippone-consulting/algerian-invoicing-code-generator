<?php
declare(strict_types=1);

namespace Hippone\InvoiceCode\Model;

use DateTimeImmutable;

/**
 * Interface IdentifiableProvider
 * @package Hippone\InvoiceCode\Model
 */
interface IdentifiableProvider
{
    public function nextCode(DateTimeImmutable $year): CodeComponents;
}