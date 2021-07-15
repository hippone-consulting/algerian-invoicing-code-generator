<?php
declare(strict_types=1);

namespace Hippone\InvoiceCode\Test\Persistence\SQLite;

use DateTimeImmutable;
use Hippone\InvoiceCode\Model\CodeComponents;
use Hippone\InvoiceCode\Model\IdentifiableProvider;
use PDO;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertInstanceOf;

class SQLiteIdentifiableProviderTest extends TestCase
{
    private IdentifiableProvider $identifiableProvider;
    private PDO $pdo;

    protected function setUp(): void
    {
        $this->pdo = new PDO('sqlite:./tests/Persistence/SQLite/invoices.db');
        $this->pdo->exec(
            '
                        CREATE TABLE IF NOT EXISTS invoices (
                        id   INTEGER PRIMARY KEY,
                        created_at DATE
                    )'
            );
        $this->identifiableProvider = new SQLiteIdentifiableProvider($this->pdo);
    }

    protected function tearDown(): void
    {
        $this->pdo->exec('DROP TABLE invoices');
    }


    public function it_can_give_next_code_for_empty_list()
    {
        $year = DateTimeImmutable::createFromFormat('Y', '2021');
        $code = $this->identifiableProvider->nextCode($year);
        assertInstanceOf(CodeComponents::class, $code);
        assertEquals('0001/2021', $code->toString());
    }

    /** @test */
    public function it_can_give_next_code_for_non_empty_list()
    {
        $currentYear = (new DateTimeImmutable)->format('Y');

        $command = $this->pdo->prepare(
            '
                    INSERT INTO invoices (created_at) 
                    VALUES (datetime("now")) 
                   '
        );

        $command->execute();
        $statement = $this->pdo->prepare(
            '
                        SELECT COUNT(*) FROM invoices As i WHERE strftime("%Y", i.created_at) = :currentYear
                   '
        );
        $statement->bindValue(':currentYear', $currentYear);
        $statement->execute();
        $currentCount = $statement->fetchColumn();
        assertEquals(1, $currentCount);
        $code = $this->identifiableProvider->nextCode(
            DateTimeImmutable::createFromFormat('Y', $currentYear)
        );
        $expected = sprintf('000%s/%s', $currentCount + 1, $currentYear);
        assertInstanceOf(CodeComponents::class, $code);
        assertEquals($expected, $code->toString());
    }
}