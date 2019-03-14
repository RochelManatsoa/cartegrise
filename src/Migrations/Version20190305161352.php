<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190305161352 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D1AB947A4');
        $this->addSql('DROP INDEX UNIQ_6EEAA67D1AB947A4 ON commande');
        $this->addSql('ALTER TABLE commande DROP taxe_id');
        $this->addSql('ALTER TABLE taxes ADD commande_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE taxes ADD CONSTRAINT FK_C28EA7F882EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C28EA7F882EA2E54 ON taxes (commande_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE commande ADD taxe_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D1AB947A4 FOREIGN KEY (taxe_id) REFERENCES taxes (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6EEAA67D1AB947A4 ON commande (taxe_id)');
        $this->addSql('ALTER TABLE taxes DROP FOREIGN KEY FK_C28EA7F882EA2E54');
        $this->addSql('DROP INDEX UNIQ_C28EA7F882EA2E54 ON taxes');
        $this->addSql('ALTER TABLE taxes DROP commande_id');
    }
}
