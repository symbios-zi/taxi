<?php declare(strict_types = 1);

namespace App\Infrastructure\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180430151847 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE journeys ADD status VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE journeys ADD price NUMERIC(10, 0) NOT NULL');
        $this->addSql('ALTER TABLE journeys ADD started_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE journeys ADD finished_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE journeys DROP status');
        $this->addSql('ALTER TABLE journeys DROP price');
        $this->addSql('ALTER TABLE journeys DROP started_at');
        $this->addSql('ALTER TABLE journeys DROP finished_at');
    }
}
