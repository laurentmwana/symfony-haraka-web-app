<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241015165619 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE qrcode DROP INDEX IDX_A4FF23ECBCABAE0, ADD UNIQUE INDEX UNIQ_A4FF23ECBCABAE0 (paid_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE qrcode DROP INDEX UNIQ_A4FF23ECBCABAE0, ADD INDEX IDX_A4FF23ECBCABAE0 (paid_id)');
    }
}
