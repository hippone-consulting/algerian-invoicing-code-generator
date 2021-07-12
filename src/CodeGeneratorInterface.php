<?php
declare(strict_types=1);

namespace Hippone\InvoiceCode;

use DateTimeImmutable;
use Hippone\InvoiceCode\Model\CodeDescriptor;

interface CodeGeneratorInterface
{
    /**
     * @param DateTimeImmutable $year
     * @return CodeDescriptor
     */
    public function generateForYear(DateTimeImmutable $year): CodeDescriptor;
}