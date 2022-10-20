<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221020145833 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE panier ADD user_id_id INT NOT NULL, ADD catalogue_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF29D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF26758ECE6 FOREIGN KEY (catalogue_id_id) REFERENCES catalogue (id)');
        $this->addSql('CREATE INDEX IDX_24CC0DF29D86650F ON panier (user_id_id)');
        $this->addSql('CREATE INDEX IDX_24CC0DF26758ECE6 ON panier (catalogue_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF29D86650F');
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF26758ECE6');
        $this->addSql('DROP INDEX IDX_24CC0DF29D86650F ON panier');
        $this->addSql('DROP INDEX IDX_24CC0DF26758ECE6 ON panier');
        $this->addSql('ALTER TABLE panier DROP user_id_id, DROP catalogue_id_id');
    }
}
