<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260519000001 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create portfolio, investment_type, and allocation tables; refactor investment_snapshot to reference portfolio';
    }

    public function up(Schema $schema): void
    {
        // Create portfolio table
        $this->addSql('CREATE TABLE portfolio (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(180) NOT NULL, description LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT "(DC2Type:datetime_immutable)", PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        // Create investment_type table
        $this->addSql('CREATE TABLE investment_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(180) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        // Create allocation table
        $this->addSql('CREATE TABLE allocation (id INT AUTO_INCREMENT NOT NULL, portfolio_id INT NOT NULL, investment_type_id INT NOT NULL, percentage DECIMAL(5,2) NOT NULL, expected_annual_return DECIMAL(5,2) NOT NULL, risk_band VARCHAR(32) NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_4B7A11E4B96F7F16 FOREIGN KEY (portfolio_id) REFERENCES portfolio (id), CONSTRAINT FK_4B7A11E48FA9FA36 FOREIGN KEY (investment_type_id) REFERENCES investment_type (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        // Create indices for allocation
        $this->addSql('CREATE INDEX IDX_4B7A11E4B96F7F16 ON allocation (portfolio_id)');
        $this->addSql('CREATE INDEX IDX_4B7A11E48FA9FA36 ON allocation (investment_type_id)');

        // Modify investment_snapshot table
        // First, drop the old columns and add portfolio_id
        $this->addSql('ALTER TABLE investment_snapshot DROP portfolio_name, DROP allocation, DROP expected_annual_return, DROP risk_band');
        $this->addSql('ALTER TABLE investment_snapshot ADD portfolio_id INT NOT NULL');
        $this->addSql('ALTER TABLE investment_snapshot ADD CONSTRAINT FK_E0F70A3FB96F7F16 FOREIGN KEY (portfolio_id) REFERENCES portfolio (id)');
        $this->addSql('CREATE INDEX IDX_E0F70A3FB96F7F16 ON investment_snapshot (portfolio_id)');
    }

    public function down(Schema $schema): void
    {
        // Reverse the investment_snapshot changes
        $this->addSql('ALTER TABLE investment_snapshot DROP FOREIGN KEY FK_E0F70A3FB96F7F16');
        $this->addSql('DROP INDEX IDX_E0F70A3FB96F7F16 ON investment_snapshot');
        $this->addSql('ALTER TABLE investment_snapshot DROP portfolio_id');
        $this->addSql('ALTER TABLE investment_snapshot ADD portfolio_name VARCHAR(180) NOT NULL, ADD allocation DECIMAL(5,2) NOT NULL, ADD expected_annual_return DECIMAL(5,2) NOT NULL, ADD risk_band VARCHAR(32) NOT NULL');

        // Drop the new tables
        $this->addSql('DROP TABLE allocation');
        $this->addSql('DROP TABLE investment_type');
        $this->addSql('DROP TABLE portfolio');
    }
}
