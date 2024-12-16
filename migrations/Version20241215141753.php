<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241215141753 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE actual_level DROP FOREIGN KEY FK_B5C5B2D1CB944F1A');
        $this->addSql('ALTER TABLE actual_level DROP FOREIGN KEY FK_B5C5B2D15FB14BA7');
        $this->addSql('ALTER TABLE student_level DROP FOREIGN KEY FK_12DDB58ECB944F1A');
        $this->addSql('ALTER TABLE student_level DROP FOREIGN KEY FK_12DDB58E5FB14BA7');
        $this->addSql('DROP TABLE actual_level');
        $this->addSql('DROP TABLE student_level');
        $this->addSql('ALTER TABLE student ADD level_id INT NOT NULL, DROP identificator_path');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF335FB14BA7 FOREIGN KEY (level_id) REFERENCES level (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B723AF335FB14BA7 ON student (level_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE actual_level (id INT AUTO_INCREMENT NOT NULL, student_id INT NOT NULL, level_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_B5C5B2D1CB944F1A (student_id), INDEX IDX_B5C5B2D15FB14BA7 (level_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE student_level (student_id INT NOT NULL, level_id INT NOT NULL, INDEX IDX_12DDB58ECB944F1A (student_id), INDEX IDX_12DDB58E5FB14BA7 (level_id), PRIMARY KEY(student_id, level_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE actual_level ADD CONSTRAINT FK_B5C5B2D1CB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE actual_level ADD CONSTRAINT FK_B5C5B2D15FB14BA7 FOREIGN KEY (level_id) REFERENCES level (id)');
        $this->addSql('ALTER TABLE student_level ADD CONSTRAINT FK_12DDB58ECB944F1A FOREIGN KEY (student_id) REFERENCES student (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE student_level ADD CONSTRAINT FK_12DDB58E5FB14BA7 FOREIGN KEY (level_id) REFERENCES level (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF335FB14BA7');
        $this->addSql('DROP INDEX UNIQ_B723AF335FB14BA7 ON student');
        $this->addSql('ALTER TABLE student ADD identificator_path VARCHAR(255) NOT NULL, DROP level_id');
    }
}
