<?php
declare(strict_types=1);

namespace Hippone\InvoiceCode\Test;

use DateTimeImmutable;
use Hippone\InvoiceCode\CodeGenerator;
use Hippone\InvoiceCode\CodeGeneratorInterface;
use Hippone\InvoiceCode\Model\CodeDescriptor;
use Hippone\InvoiceCode\Persistence\Fake\FakeIdentifiableProvider;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertInstanceOf;

class CodeGeneratorTest extends TestCase
{
    private CodeGeneratorInterface $invoiceCodeGenerator;

    protected function setUp(): void
    {
        $this->invoiceCodeGenerator = new CodeGenerator(new FakeIdentifiableProvider());
    }

    /** @test */
    public function it_generates_code_for_empty_invoices_list()
    {
        $code = $this->invoiceCodeGenerator->generateForYear(
            DateTimeImmutable::createFromFormat('Y', '2021')
        );
        assertInstanceOf(CodeDescriptor::class, $code);
        assertEquals('0001', $code->sequentialNumber());
        assertEquals(DateTimeImmutable::createFromFormat('Y', '2021'), $code->year());
        assertEquals('0001/2021', $code->formatted());
    }
}