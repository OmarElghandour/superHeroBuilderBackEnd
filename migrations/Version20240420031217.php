<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240420031217 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE hero_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE hero (id VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, hero_name VARCHAR(255) NOT NULL, publisher VARCHAR(255) NOT NULL, first_appearance VARCHAR(255) NOT NULL, abilities TEXT NOT NULL, team_affiliations TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN hero.abilities IS \'(DC2Type:array)\'');
        $this->addSql('COMMENT ON COLUMN hero.team_affiliations IS \'(DC2Type:array)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE hero_id_seq CASCADE');
        $this->addSql('DROP TABLE hero');
    }
}
