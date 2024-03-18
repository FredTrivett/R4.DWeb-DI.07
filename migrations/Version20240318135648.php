<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240318135648 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lego DROP FOREIGN KEY FK_E9191FC512469DE2');
        $this->addSql('DROP INDEX IDX_E9191FC512469DE2 ON lego');
        $this->addSql('ALTER TABLE lego DROP category_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lego ADD category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE lego ADD CONSTRAINT FK_E9191FC512469DE2 FOREIGN KEY (category_id) REFERENCES lego_collection (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_E9191FC512469DE2 ON lego (category_id)');
    }
}
