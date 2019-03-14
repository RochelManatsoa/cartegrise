<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190206173432 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE demande ADD nom_demande_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A581A6DE6F FOREIGN KEY (nom_demande_id) REFERENCES type_demande (id)');
        $this->addSql('CREATE INDEX IDX_2694D7A581A6DE6F ON demande (nom_demande_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A581A6DE6F');
        $this->addSql('DROP INDEX IDX_2694D7A581A6DE6F ON demande');
        $this->addSql('ALTER TABLE demande DROP nom_demande_id');
    }
}
