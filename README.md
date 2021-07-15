# Algerian invoice code generator

The library is useful to generate code for invoices, quotes or any commercial transaction document.

## Goal
Is to provide helpful interface to generate the needed code.

## Installation

The recommended (and the best) way to install the library is by using composer:

```shell
composer require hippone/algerian-invoice-code-generator
```

## Usage

The `Hippone\InvoiceCode\CodeGenerator` code is the main component of the library, it implements `Hippone\InvoiceCode\CodeGeneratorInterface`, 
this class has one dependency (for now) that implements `Hippone\InvoiceCode\Model\IdentifiableProvider` to be provided by the client, 
this dependency is the port to the persistence layer used by the client, an example of a simple implementation which uses PDO with SQLite would be:

```php
<?php
declare(strict_types=1);

namespace MyNamespace\Persistence\SQLite;

use DateTimeImmutable;
use Hippone\InvoiceCode\Model\CodeComponents;
use Hippone\InvoiceCode\Model\IdentifiableProvider;
use PDO;

class SQLiteIdentifiableProvider implements IdentifiableProvider
{
    private PDO $pdo;
    
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function nextCode(DateTimeImmutable $year): CodeComponents
    {
         $statement = $this->pdo->prepare('
                            SELECT COUNT(*) FROM invoices 
                            AS i 
                            WHERE strftime("%Y", i.created_at) = :currentYear
        ');
        $statement->bindValue(':currentYear', $year->format('Y'));
        $statement->execute();
        $currentCount = $statement->fetchColumn();
        $sequentialNumber = $currentCount + 1;
        return CodeComponents::from($sequentialNumber, $year);
    }
}
```

Once the `Hippone\InvoiceCode\Model\IdentifiableProvider` is implemented, the `Hippone\InvoiceCode\CodeGenerator` class can be instantiated and used like the following:

```php
$codeGenerator = new CodeGenerator(new SQLiteIdentifiableProvider($pdo)); // assume PDO object is instantiated
$codeGenerator->generateForYear(DateTimeImmutable::createFromFormat('Y', '2021')); // replace 2021 by the desired value
```

## License
[MIT License](LICENSE).