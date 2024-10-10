<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241010093822 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE qrcode (id INT AUTO_INCREMENT NOT NULL, paid_id INT NOT NULL, qrcode_at DATETIME NOT NULL, image VARCHAR(255) NOT NULL, INDEX IDX_A4FF23ECBCABAE0 (paid_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE qrcode ADD CONSTRAINT FK_A4FF23ECBCABAE0 FOREIGN KEY (paid_id) REFERENCES paid (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE qrcode DROP FOREIGN KEY FK_A4FF23ECBCABAE0');
        $this->addSql('DROP TABLE qrcode');
    }
}
