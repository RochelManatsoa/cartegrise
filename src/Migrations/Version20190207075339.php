<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190207075339 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE documents ADD type_demande_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE documents ADD CONSTRAINT FK_A2B072889DEA883D FOREIGN KEY (type_demande_id) REFERENCES type_demande (id)');
        $this->addSql('CREATE INDEX IDX_A2B072889DEA883D ON documents (type_demande_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE documents DROP FOREIGN KEY FK_A2B072889DEA883D');
        $this->addSql('DROP INDEX IDX_A2B072889DEA883D ON documents');
        $this->addSql('ALTER TABLE documents DROP type_demande_id');
    }
}
