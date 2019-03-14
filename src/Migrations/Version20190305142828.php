<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190305142828 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE taxes (id INT AUTO_INCREMENT NOT NULL, taxe_regionale DOUBLE PRECISION NOT NULL, taxe35cv DOUBLE PRECISION NOT NULL, taxe_parafiscale DOUBLE PRECISION NOT NULL, taxe_co2 DOUBLE PRECISION NOT NULL, taxe_malus DOUBLE PRECISION NOT NULL, taxe_siv DOUBLE PRECISION NOT NULL, taxe_redevance_siv DOUBLE PRECISION NOT NULL, taxe_totale DOUBLE PRECISION NOT NULL, vin VARCHAR(255) NOT NULL, co2 INT NOT NULL, puissance INT NOT NULL, genre INT NOT NULL, ptac INT NOT NULL, energie INT NOT NULL, date_mec DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commande ADD taxes_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D36D06393 FOREIGN KEY (taxes_id) REFERENCES taxes (id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67D36D06393 ON commande (taxes_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D36D06393');
        $this->addSql('DROP TABLE taxes');
        $this->addSql('DROP INDEX IDX_6EEAA67D36D06393 ON commande');
        $this->addSql('ALTER TABLE commande DROP taxes_id');
    }
}
