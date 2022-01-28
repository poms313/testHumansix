<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220127173415 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP INDEX UNIQ_F52993989395C3F3, ADD INDEX IDX_F52993989395C3F3 (customer_id)');
        $this->addSql('DROP INDEX UNIQ_D34A04ADF9038C4 ON product');
        $this->addSql('ALTER TABLE product DROP quantity');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP INDEX IDX_F52993989395C3F3, ADD UNIQUE INDEX UNIQ_F52993989395C3F3 (customer_id)');
        $this->addSql('ALTER TABLE product ADD quantity INT NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D34A04ADF9038C4 ON product (sku)');
    }
}
