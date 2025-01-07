<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250106181140 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE panier_products (panier_id INT NOT NULL, products_id INT NOT NULL, INDEX IDX_29FF5328F77D927C (panier_id), INDEX IDX_29FF53286C8A81A9 (products_id), PRIMARY KEY(panier_id, products_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE panier_products ADD CONSTRAINT FK_29FF5328F77D927C FOREIGN KEY (panier_id) REFERENCES panier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE panier_products ADD CONSTRAINT FK_29FF53286C8A81A9 FOREIGN KEY (products_id) REFERENCES products (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE panier ADD prix_unitaire NUMERIC(5, 2) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE panier_products DROP FOREIGN KEY FK_29FF5328F77D927C');
        $this->addSql('ALTER TABLE panier_products DROP FOREIGN KEY FK_29FF53286C8A81A9');
        $this->addSql('DROP TABLE panier_products');
        $this->addSql('ALTER TABLE panier DROP prix_unitaire');
    }
}
