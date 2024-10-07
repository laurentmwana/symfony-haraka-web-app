<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241005111104 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE paid (id INT AUTO_INCREMENT NOT NULL, student_id INT NOT NULL, level_id INT NOT NULL, state VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_FD8EAB38CB944F1A (student_id), INDEX IDX_FD8EAB385FB14BA7 (level_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment (id INT AUTO_INCREMENT NOT NULL, student_id INT NOT NULL, amount_id INT NOT NULL, installment_id INT NOT NULL, level_id INT NOT NULL, payment_at DATETIME NOT NULL, INDEX IDX_6D28840DCB944F1A (student_id), INDEX IDX_6D28840D9BB17698 (amount_id), INDEX IDX_6D28840DF03B5436 (installment_id), INDEX IDX_6D28840D5FB14BA7 (level_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE paid ADD CONSTRAINT FK_FD8EAB38CB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE paid ADD CONSTRAINT FK_FD8EAB385FB14BA7 FOREIGN KEY (level_id) REFERENCES level (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DCB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D9BB17698 FOREIGN KEY (amount_id) REFERENCES amount (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DF03B5436 FOREIGN KEY (installment_id) REFERENCES installment (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D5FB14BA7 FOREIGN KEY (level_id) REFERENCES level (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE paid DROP FOREIGN KEY FK_FD8EAB38CB944F1A');
        $this->addSql('ALTER TABLE paid DROP FOREIGN KEY FK_FD8EAB385FB14BA7');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840DCB944F1A');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840D9BB17698');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840DF03B5436');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840D5FB14BA7');
        $this->addSql('DROP TABLE paid');
        $this->addSql('DROP TABLE payment');
    }
}
