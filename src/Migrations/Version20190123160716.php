<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190123160716 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE type_demande DROP FOREIGN KEY FK_EB5B8505F0F2752');
        $this->addSql('DROP INDEX IDX_EB5B8505F0F2752 ON type_demande');
        $this->addSql('ALTER TABLE type_demande DROP documents_id');
        $this->addSql('ALTER TABLE documents ADD type VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE documents DROP type');
        $this->addSql('ALTER TABLE type_demande ADD documents_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE type_demande ADD CONSTRAINT FK_EB5B8505F0F2752 FOREIGN KEY (documents_id) REFERENCES documents (id)');
        $this->addSql('CREATE INDEX IDX_EB5B8505F0F2752 ON type_demande (documents_id)');
    }
}
