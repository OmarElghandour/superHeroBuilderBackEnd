<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240422154055 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE hero_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('ALTER TABLE hero ADD powers TEXT NOT NULL');
        $this->addSql('ALTER TABLE hero ALTER name DROP NOT NULL');
        $this->addSql('ALTER TABLE hero ALTER hero_name DROP NOT NULL');
        $this->addSql('ALTER TABLE hero ALTER publisher DROP NOT NULL');
        $this->addSql('ALTER TABLE hero ALTER first_appearance DROP NOT NULL');
        $this->addSql('COMMENT ON COLUMN hero.powers IS \'(DC2Type:array)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE hero_id_seq CASCADE');
        $this->addSql('ALTER TABLE hero DROP powers');
        $this->addSql('ALTER TABLE hero ALTER name SET NOT NULL');
        $this->addSql('ALTER TABLE hero ALTER hero_name SET NOT NULL');
        $this->addSql('ALTER TABLE hero ALTER publisher SET NOT NULL');
        $this->addSql('ALTER TABLE hero ALTER first_appearance SET NOT NULL');
    }
}
