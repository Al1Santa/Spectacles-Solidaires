<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220503093140 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(32) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `show` (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(64) NOT NULL, content LONGTEXT NOT NULL, link_video VARCHAR(255) DEFAULT NULL, link_sound VARCHAR(255) DEFAULT NULL, picture_1 VARCHAR(255) DEFAULT NULL, picture_2 VARCHAR(255) DEFAULT NULL, picture_3 VARCHAR(255) DEFAULT NULL, time TIME NOT NULL, age INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE show_category (show_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_3F28F82ED0C1FC64 (show_id), INDEX IDX_3F28F82E12469DE2 (category_id), PRIMARY KEY(show_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, firstname VARCHAR(64) NOT NULL, lastname VARCHAR(64) NOT NULL, avatar VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_show (user_id INT NOT NULL, show_id INT NOT NULL, INDEX IDX_488F95C8A76ED395 (user_id), INDEX IDX_488F95C8D0C1FC64 (show_id), PRIMARY KEY(user_id, show_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE show_category ADD CONSTRAINT FK_3F28F82ED0C1FC64 FOREIGN KEY (show_id) REFERENCES `show` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE show_category ADD CONSTRAINT FK_3F28F82E12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_show ADD CONSTRAINT FK_488F95C8A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_show ADD CONSTRAINT FK_488F95C8D0C1FC64 FOREIGN KEY (show_id) REFERENCES `show` (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE show_category DROP FOREIGN KEY FK_3F28F82E12469DE2');
        $this->addSql('ALTER TABLE show_category DROP FOREIGN KEY FK_3F28F82ED0C1FC64');
        $this->addSql('ALTER TABLE user_show DROP FOREIGN KEY FK_488F95C8D0C1FC64');
        $this->addSql('ALTER TABLE user_show DROP FOREIGN KEY FK_488F95C8A76ED395');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE `show`');
        $this->addSql('DROP TABLE show_category');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE user_show');
    }
}
