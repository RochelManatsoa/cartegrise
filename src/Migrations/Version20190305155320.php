<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190305155320 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D36D06393');
        $this->addSql('DROP INDEX IDX_6EEAA67D36D06393 ON commande');
        $this->addSql('ALTER TABLE commande CHANGE taxes_id taxe_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D1AB947A4 FOREIGN KEY (taxe_id) REFERENCES taxes (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6EEAA67D1AB947A4 ON commande (taxe_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D1AB947A4');
        $this->addSql('DROP INDEX UNIQ_6EEAA67D1AB947A4 ON commande');
        $this->addSql('ALTER TABLE commande CHANGE taxe_id taxes_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D36D06393 FOREIGN KEY (taxes_id) REFERENCES taxes (id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67D36D06393 ON commande (taxes_id)');
    }
}
