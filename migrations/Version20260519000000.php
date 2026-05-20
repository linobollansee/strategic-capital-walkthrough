<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260519000000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create the investment_snapshot table for the walkthrough project.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE investment_snapshot (id INT AUTO_INCREMENT NOT NULL, portfolio_name VARCHAR(180) NOT NULL, allocation DECIMAL(5,2) NOT NULL, expected_annual_return DECIMAL(5,2) NOT NULL, risk_band VARCHAR(32) NOT NULL, reviewed_at DATETIME NOT NULL COMMENT "(DC2Type:datetime_immutable)", PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE investment_snapshot');
    }
}
