<?php
declare(strict_types=1);

namespace Hippone\InvoiceCode\Test\Persistence\SQLite;

use DateTimeImmutable;
use Hippone\InvoiceCode\Model\CodeComponents;
use Hippone\InvoiceCode\Model\IdentifiableProvider;
use PDO;

class SQLiteIdentifiableProvider implements IdentifiableProvider
{
    private PDO $pdo;

    /**
     * SQLiteIdentifiableProvider constructor.
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function nextCode(DateTimeImmutable $year): CodeComponents
    {
        $statement = $this->pdo->prepare('SELECT COUNT(*) FROM invoices');
        $statement->execute();
        $currentCount = $statement->fetchColumn();
        $sequentialNumber = $currentCount + 1;
        return CodeComponents::from($sequentialNumber, $year);
    }
}