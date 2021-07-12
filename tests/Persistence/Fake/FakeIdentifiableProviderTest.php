<?php
declare(strict_types=1);

namespace Hippone\InvoiceCode\Test\Persistence\Fake;

use DateTimeImmutable;
use Hippone\InvoiceCode\Model\IdentifiableProvider;
use Hippone\InvoiceCode\Model\CodeComponents;
use Hippone\InvoiceCode\Persistence\Fake\FakeIdentifiableProvider;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertInstanceOf;

class FakeIdentifiableProviderTest extends TestCase
{
    private IdentifiableProvider $identifiableProvider;

    protected function setUp(): void
    {
        $this->identifiableProvider = new FakeIdentifiableProvider();
    }

    /** @test */
    public function it_can_give_next_code_for_empty_list()
    {
        $year = DateTimeImmutable::createFromFormat('Y', '2021');
        $code = $this->identifiableProvider->nextCode($year);
        assertInstanceOf(CodeComponents::class, $code);
        assertEquals('1/2021', $code->toString());
    }
}