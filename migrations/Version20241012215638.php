<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241012215638 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE choice_method_payment (id INT AUTO_INCREMENT NOT NULL, payment_method_id INT NOT NULL, faculty_id INT NOT NULL, year_academic_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_DDC0C0905AA1164F (payment_method_id), INDEX IDX_DDC0C090680CAB68 (faculty_id), INDEX IDX_DDC0C090E7EC8C0F (year_academic_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notification (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, priority INT NOT NULL, to_route VARCHAR(255) NOT NULL, eye TINYINT(1) NOT NULL, eye_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_BF5476CAA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment_method (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, number_account VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_7B61A1F65E237E06 (name), UNIQUE INDEX UNIQ_7B61A1F6AA46231 (number_account), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE choice_method_payment ADD CONSTRAINT FK_DDC0C0905AA1164F FOREIGN KEY (payment_method_id) REFERENCES payment_method (id)');
        $this->addSql('ALTER TABLE choice_method_payment ADD CONSTRAINT FK_DDC0C090680CAB68 FOREIGN KEY (faculty_id) REFERENCES faculty (id)');
        $this->addSql('ALTER TABLE choice_method_payment ADD CONSTRAINT FK_DDC0C090E7EC8C0F FOREIGN KEY (year_academic_id) REFERENCES year_academic (id)');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE choice_method_payment DROP FOREIGN KEY FK_DDC0C0905AA1164F');
        $this->addSql('ALTER TABLE choice_method_payment DROP FOREIGN KEY FK_DDC0C090680CAB68');
        $this->addSql('ALTER TABLE choice_method_payment DROP FOREIGN KEY FK_DDC0C090E7EC8C0F');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CAA76ED395');
        $this->addSql('DROP TABLE choice_method_payment');
        $this->addSql('DROP TABLE notification');
        $this->addSql('DROP TABLE payment_method');
    }
}
