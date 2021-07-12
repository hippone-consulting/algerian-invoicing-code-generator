<?php
declare(strict_types=1);

namespace Hippone\InvoiceCode;

use DateTimeImmutable;
use Hippone\InvoiceCode\Model\CodeDescriptor;
use Hippone\InvoiceCode\Model\IdentifiableProvider;

/**
 * Class CodeGenerator
 * @package Hippone\InvoiceCode
 */
final class CodeGenerator implements CodeGeneratorInterface
{
    private IdentifiableProvider $identifiableProvider;

    /**
     * CodeGenerator constructor.
     * @param IdentifiableProvider $identifiableProvider
     */
    public function __construct(IdentifiableProvider $identifiableProvider)
    {
        $this->identifiableProvider = $identifiableProvider;
    }

    /**
     * @inheritdoc
     */
    public function generateForYear(DateTimeImmutable $year): CodeDescriptor
    {
        $code = $this->identifiableProvider->nextCode($year);
        return $code->toDescriptor();
    }
}