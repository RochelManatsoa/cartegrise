<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190122150625 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE documents_type_demande (documents_id INT NOT NULL, type_demande_id INT NOT NULL, INDEX IDX_94D097875F0F2752 (documents_id), INDEX IDX_94D097879DEA883D (type_demande_id), PRIMARY KEY(documents_id, type_demande_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE documents_type_demande ADD CONSTRAINT FK_94D097875F0F2752 FOREIGN KEY (documents_id) REFERENCES documents (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE documents_type_demande ADD CONSTRAINT FK_94D097879DEA883D FOREIGN KEY (type_demande_id) REFERENCES type_demande (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE documents DROP FOREIGN KEY FK_A2B07288C54C8C93');
        $this->addSql('DROP INDEX IDX_A2B07288C54C8C93 ON documents');
        $this->addSql('ALTER TABLE documents DROP type_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE documents_type_demande');
        $this->addSql('ALTER TABLE documents ADD type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE documents ADD CONSTRAINT FK_A2B07288C54C8C93 FOREIGN KEY (type_id) REFERENCES type_demande (id)');
        $this->addSql('CREATE INDEX IDX_A2B07288C54C8C93 ON documents (type_id)');
    }
}
