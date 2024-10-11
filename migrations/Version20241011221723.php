<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241011221723 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840DBCABAE0');
        $this->addSql('DROP INDEX IDX_6D28840DBCABAE0 ON payment');
        $this->addSql('ALTER TABLE payment DROP paid_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE payment ADD paid_id INT NOT NULL');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DBCABAE0 FOREIGN KEY (paid_id) REFERENCES paid (id)');
        $this->addSql('CREATE INDEX IDX_6D28840DBCABAE0 ON payment (paid_id)');
    }
}
