<?php declare(strict_types = 1);

namespace App\Infrastructure\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180430153858 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE journeys ADD passenger_id UUID NOT NULL');
        $this->addSql('ALTER TABLE journeys ADD driver_id UUID NOT NULL');
        $this->addSql('ALTER TABLE journeys ADD CONSTRAINT FK_231E1B094502E565 FOREIGN KEY (passenger_id) REFERENCES passengers (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE journeys ADD CONSTRAINT FK_231E1B09C3423909 FOREIGN KEY (driver_id) REFERENCES drivers (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_231E1B094502E565 ON journeys (passenger_id)');
        $this->addSql('CREATE INDEX IDX_231E1B09C3423909 ON journeys (driver_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE journeys DROP CONSTRAINT FK_231E1B094502E565');
        $this->addSql('ALTER TABLE journeys DROP CONSTRAINT FK_231E1B09C3423909');
        $this->addSql('DROP INDEX IDX_231E1B094502E565');
        $this->addSql('DROP INDEX IDX_231E1B09C3423909');
        $this->addSql('ALTER TABLE journeys DROP passenger_id');
        $this->addSql('ALTER TABLE journeys DROP driver_id');
    }
}
