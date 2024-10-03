<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241003120624 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE checker (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, gender VARCHAR(255) NOT NULL, number_phone VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_59D70FD2FF061415 (number_phone), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE level (id INT AUTO_INCREMENT NOT NULL, programme_id INT NOT NULL, sector_id INT NOT NULL, year_academic_id INT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_9AEACC1362BB7AEE (programme_id), INDEX IDX_9AEACC13DE95C867 (sector_id), INDEX IDX_9AEACC13E7EC8C0F (year_academic_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) DEFAULT NULL, gender VARCHAR(255) NOT NULL, happy DATE NOT NULL, number_phone VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_B723AF33FF061415 (number_phone), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student_level (student_id INT NOT NULL, level_id INT NOT NULL, INDEX IDX_12DDB58ECB944F1A (student_id), INDEX IDX_12DDB58E5FB14BA7 (level_id), PRIMARY KEY(student_id, level_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE level ADD CONSTRAINT FK_9AEACC1362BB7AEE FOREIGN KEY (programme_id) REFERENCES programme (id)');
        $this->addSql('ALTER TABLE level ADD CONSTRAINT FK_9AEACC13DE95C867 FOREIGN KEY (sector_id) REFERENCES sector (id)');
        $this->addSql('ALTER TABLE level ADD CONSTRAINT FK_9AEACC13E7EC8C0F FOREIGN KEY (year_academic_id) REFERENCES year_academic (id)');
        $this->addSql('ALTER TABLE student_level ADD CONSTRAINT FK_12DDB58ECB944F1A FOREIGN KEY (student_id) REFERENCES student (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE student_level ADD CONSTRAINT FK_12DDB58E5FB14BA7 FOREIGN KEY (level_id) REFERENCES level (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE level DROP FOREIGN KEY FK_9AEACC1362BB7AEE');
        $this->addSql('ALTER TABLE level DROP FOREIGN KEY FK_9AEACC13DE95C867');
        $this->addSql('ALTER TABLE level DROP FOREIGN KEY FK_9AEACC13E7EC8C0F');
        $this->addSql('ALTER TABLE student_level DROP FOREIGN KEY FK_12DDB58ECB944F1A');
        $this->addSql('ALTER TABLE student_level DROP FOREIGN KEY FK_12DDB58E5FB14BA7');
        $this->addSql('DROP TABLE checker');
        $this->addSql('DROP TABLE level');
        $this->addSql('DROP TABLE student');
        $this->addSql('DROP TABLE student_level');
    }
}
