<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190108150832 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE marges ADD id_commande_id INT DEFAULT NULL, DROP id_commande');
        $this->addSql('ALTER TABLE marges ADD CONSTRAINT FK_FCD2E90C9AF8E3A3 FOREIGN KEY (id_commande_id) REFERENCES demande (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FCD2E90C9AF8E3A3 ON marges (id_commande_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE marges DROP FOREIGN KEY FK_FCD2E90C9AF8E3A3');
        $this->addSql('DROP INDEX UNIQ_FCD2E90C9AF8E3A3 ON marges');
        $this->addSql('ALTER TABLE marges ADD id_commande INT NOT NULL, DROP id_commande_id');
    }
}
