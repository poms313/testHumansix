<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220204194832 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE waiting_order_cart (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, item_quantity INT NOT NULL, INDEX IDX_17CE218E4584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE waiting_order_cart ADD CONSTRAINT FK_17CE218E4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('DROP TABLE actual_cart_item');
        $this->addSql('ALTER TABLE cart_item ADD CONSTRAINT FK_F0FE25274584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_F0FE25274584665A ON cart_item (product_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE actual_cart_item (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, item_quantity INT NOT NULL, INDEX IDX_CB1843C44584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE actual_cart_item ADD CONSTRAINT FK_CB1843C44584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('DROP TABLE waiting_order_cart');
        $this->addSql('ALTER TABLE cart_item DROP FOREIGN KEY FK_F0FE25274584665A');
        $this->addSql('DROP INDEX IDX_F0FE25274584665A ON cart_item');
    }
}
