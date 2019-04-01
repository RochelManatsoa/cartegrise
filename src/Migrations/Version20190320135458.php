<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190320135458 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A54A4A3511');
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A59E17F041');
        $this->addSql('DROP INDEX UNIQ_2694D7A59E17F041 ON demande');
        $this->addSql('DROP INDEX UNIQ_2694D7A54A4A3511 ON demande');
        $this->addSql('ALTER TABLE demande DROP ancien_titulaire_id, DROP vehicule_id');
        $this->addSql('ALTER TABLE client CHANGE client_dpt_naissance client_dpt_naissance VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE vehicule DROP FOREIGN KEY FK_292FFF1DD253699B');
        $this->addSql('DROP INDEX UNIQ_292FFF1DD253699B ON vehicule');
        $this->addSql('ALTER TABLE vehicule DROP cotitulaire_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE client CHANGE client_dpt_naissance client_dpt_naissance INT NOT NULL');
        $this->addSql('ALTER TABLE demande ADD ancien_titulaire_id INT DEFAULT NULL, ADD vehicule_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A54A4A3511 FOREIGN KEY (vehicule_id) REFERENCES vehicule (id)');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A59E17F041 FOREIGN KEY (ancien_titulaire_id) REFERENCES ancientitulaire (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2694D7A59E17F041 ON demande (ancien_titulaire_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2694D7A54A4A3511 ON demande (vehicule_id)');
        $this->addSql('ALTER TABLE vehicule ADD cotitulaire_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE vehicule ADD CONSTRAINT FK_292FFF1DD253699B FOREIGN KEY (cotitulaire_id) REFERENCES vehicule (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_292FFF1DD253699B ON vehicule (cotitulaire_id)');
    }
}
