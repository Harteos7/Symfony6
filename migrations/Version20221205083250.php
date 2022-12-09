<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221205083250 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE catalogue (id INT AUTO_INCREMENT NOT NULL, menu_id INT NOT NULL, image VARCHAR(50) NOT NULL, description VARCHAR(150) DEFAULT NULL, nom VARCHAR(50) NOT NULL, INDEX IDX_59A699F5CCD7E912 (menu_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu (id INT AUTO_INCREMENT NOT NULL, image VARCHAR(60) NOT NULL, nom VARCHAR(60) NOT NULL, description VARCHAR(200) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE panier (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, catalogue_id_id INT NOT NULL, INDEX IDX_24CC0DF29D86650F (user_id_id), INDEX IDX_24CC0DF26758ECE6 (catalogue_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, name VARCHAR(100) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE catalogue ADD CONSTRAINT FK_59A699F5CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id)');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF29D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF26758ECE6 FOREIGN KEY (catalogue_id_id) REFERENCES catalogue (id)');

        $this->addSQl("INSERT INTO `user` (`id`, `email`, `roles`, `password`, `adresse`, `name`) VALUES
        (1, 'test2@gmail.com', '[]', '\$2y\$13\$HBdxCorYZAlmG32XkrsbTu4w9saA6izs.y4ZqBeMzehVff8Bd4ITK', 'name', 'Yoann'),
        (2, 'test@gmail.com', '[]', '\$2y\$13\$mzm.0H5rxrPGiJudXrZnBuuxQ310PH.2fcZKO0o1Ie/fWoalvT5mG', 'test', 'Yoann1'),
        (3, 'johndoe@example.com', '[]', '\$2y\$13\$av5yRLdzPxIP0.8tOu0.lOxlMSrY6osyR40IJISZ4Sh2.W6ubDZTi', 'test', 'Johndoe')");

        $this->addSQl("INSERT INTO `menu` (`id`, `image`, `nom`, `description`) VALUES
        (1, '/build/images/burger.png', 'Burger', 'Un bon burger'),
        (2, '/build/images/pizza.png', 'Pizza', 'Pizza cuite au feu')");

        $this->addSQl("INSERT INTO `catalogue` (`id`, `menu_id`, `image`, `description`, `nom`) VALUES
        (1, 1, '/build/images/miam1.png', 'un burgur', 'burgur'),
        (2, 1, '/build/images/miam1.png', 'Un autre burgur', 'burgur 2')");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE catalogue DROP FOREIGN KEY FK_59A699F5CCD7E912');
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF29D86650F');
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF26758ECE6');
        $this->addSql('DROP TABLE catalogue');
        $this->addSql('DROP TABLE menu');
        $this->addSql('DROP TABLE panier');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
