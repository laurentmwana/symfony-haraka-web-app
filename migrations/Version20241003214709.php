<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241003214709 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE actual_level (id INT AUTO_INCREMENT NOT NULL, student_id INT NOT NULL, level_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_B5C5B2D1CB944F1A (student_id), INDEX IDX_B5C5B2D15FB14BA7 (level_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE actual_level ADD CONSTRAINT FK_B5C5B2D1CB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE actual_level ADD CONSTRAINT FK_B5C5B2D15FB14BA7 FOREIGN KEY (level_id) REFERENCES level (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE actual_level DROP FOREIGN KEY FK_B5C5B2D1CB944F1A');
        $this->addSql('ALTER TABLE actual_level DROP FOREIGN KEY FK_B5C5B2D15FB14BA7');
        $this->addSql('DROP TABLE actual_level');
    }
}
