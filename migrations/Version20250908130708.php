<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250908130708 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE listing DROP FOREIGN KEY FK_CB0048D4F675F31B');
        $this->addSql('DROP INDEX IDX_CB0048D4F675F31B ON listing');
        $this->addSql('ALTER TABLE listing CHANGE author_id agent_id INT NOT NULL');
        $this->addSql('ALTER TABLE listing ADD CONSTRAINT FK_CB0048D43414710B FOREIGN KEY (agent_id) REFERENCES agent (id)');
        $this->addSql('CREATE INDEX IDX_CB0048D43414710B ON listing (agent_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE listing DROP FOREIGN KEY FK_CB0048D43414710B');
        $this->addSql('DROP INDEX IDX_CB0048D43414710B ON listing');
        $this->addSql('ALTER TABLE listing CHANGE agent_id author_id INT NOT NULL');
        $this->addSql('ALTER TABLE listing ADD CONSTRAINT FK_CB0048D4F675F31B FOREIGN KEY (author_id) REFERENCES agent (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_CB0048D4F675F31B ON listing (author_id)');
    }
}
