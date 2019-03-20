<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190320083140 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE fichier ADD CONSTRAINT FK_9B76551F80E95E18 FOREIGN KEY (demande_id) REFERENCES demande (id)');
        $this->addSql('ALTER TABLE fichier ADD CONSTRAINT FK_9B76551F19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE fichier ADD CONSTRAINT FK_9B76551FC54C8C93 FOREIGN KEY (type_id) REFERENCES documents (id)');
        $this->addSql('ALTER TABLE demande ADD ancien_titulaire_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A59E17F041 FOREIGN KEY (ancien_titulaire_id) REFERENCES ancientitulaire (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2694D7A59E17F041 ON demande (ancien_titulaire_id)');
        $this->addSql('ALTER TABLE taxes ADD CONSTRAINT FK_C28EA7F882EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE tarifs_prestations ADD CONSTRAINT FK_D863AC2D82EA2E54 FOREIGN KEY (commande_id) REFERENCES type_demande (id)');
        $this->addSql('ALTER TABLE vehicule ADD CONSTRAINT FK_292FFF1D688CB924 FOREIGN KEY (vehicule_ancientitulaire_id) REFERENCES ancientitulaire (id)');
        $this->addSql('ALTER TABLE vehicule ADD CONSTRAINT FK_292FFF1D31881814 FOREIGN KEY (vehicule_cartegrise_id) REFERENCES cartegrise (id)');
        $this->addSql('ALTER TABLE vehicule ADD CONSTRAINT FK_292FFF1DDCF6C4B7 FOREIGN KEY (vehicule_demande_id) REFERENCES demande (id)');
        $this->addSql('ALTER TABLE vehicule ADD CONSTRAINT FK_292FFF1DB51BC29A FOREIGN KEY (vehicule_client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE vehicule ADD CONSTRAINT FK_292FFF1D19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE vehicule ADD CONSTRAINT FK_292FFF1D7F1824A4 FOREIGN KEY (infosup_id) REFERENCES info_sup_veh (id)');
        $this->addSql('ALTER TABLE vehicule ADD CONSTRAINT FK_292FFF1DA10273AA FOREIGN KEY (titulaire_id) REFERENCES new_titulaire (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A59E17F041');
        $this->addSql('DROP INDEX UNIQ_2694D7A59E17F041 ON demande');
        $this->addSql('ALTER TABLE demande DROP ancien_titulaire_id');
        $this->addSql('ALTER TABLE fichier DROP FOREIGN KEY FK_9B76551F80E95E18');
        $this->addSql('ALTER TABLE fichier DROP FOREIGN KEY FK_9B76551F19EB6921');
        $this->addSql('ALTER TABLE fichier DROP FOREIGN KEY FK_9B76551FC54C8C93');
        $this->addSql('ALTER TABLE tarifs_prestations DROP FOREIGN KEY FK_D863AC2D82EA2E54');
        $this->addSql('ALTER TABLE taxes DROP FOREIGN KEY FK_C28EA7F882EA2E54');
        $this->addSql('ALTER TABLE vehicule DROP FOREIGN KEY FK_292FFF1D688CB924');
        $this->addSql('ALTER TABLE vehicule DROP FOREIGN KEY FK_292FFF1D31881814');
        $this->addSql('ALTER TABLE vehicule DROP FOREIGN KEY FK_292FFF1DDCF6C4B7');
        $this->addSql('ALTER TABLE vehicule DROP FOREIGN KEY FK_292FFF1DB51BC29A');
        $this->addSql('ALTER TABLE vehicule DROP FOREIGN KEY FK_292FFF1D19EB6921');
        $this->addSql('ALTER TABLE vehicule DROP FOREIGN KEY FK_292FFF1D7F1824A4');
        $this->addSql('ALTER TABLE vehicule DROP FOREIGN KEY FK_292FFF1DA10273AA');
    }
}
