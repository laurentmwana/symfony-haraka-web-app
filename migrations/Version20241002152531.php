<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241002152531 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE amount (id INT AUTO_INCREMENT NOT NULL, programme_id INT NOT NULL, year_academic_id INT NOT NULL, price DOUBLE PRECISION NOT NULL, max_number_installment INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_8EA1704262BB7AEE (programme_id), INDEX IDX_8EA17042E7EC8C0F (year_academic_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE installment (id INT AUTO_INCREMENT NOT NULL, amount_id INT NOT NULL, price DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, priority INT NOT NULL, INDEX IDX_4B778ACD9BB17698 (amount_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE amount ADD CONSTRAINT FK_8EA1704262BB7AEE FOREIGN KEY (programme_id) REFERENCES programme (id)');
        $this->addSql('ALTER TABLE amount ADD CONSTRAINT FK_8EA17042E7EC8C0F FOREIGN KEY (year_academic_id) REFERENCES year_academic (id)');
        $this->addSql('ALTER TABLE installment ADD CONSTRAINT FK_4B778ACD9BB17698 FOREIGN KEY (amount_id) REFERENCES amount (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE amount DROP FOREIGN KEY FK_8EA1704262BB7AEE');
        $this->addSql('ALTER TABLE amount DROP FOREIGN KEY FK_8EA17042E7EC8C0F');
        $this->addSql('ALTER TABLE installment DROP FOREIGN KEY FK_4B778ACD9BB17698');
        $this->addSql('DROP TABLE amount');
        $this->addSql('DROP TABLE installment');
    }
}
