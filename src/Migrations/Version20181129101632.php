<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181129101632 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C744045519E5B62F');
        $this->addSql('DROP INDEX UNIQ_C744045519E5B62F ON client');
        $this->addSql('ALTER TABLE client DROP client_compte_id');
        $this->addSql('ALTER TABLE fos_user ADD client_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE fos_user ADD CONSTRAINT FK_957A647919EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_957A647919EB6921 ON fos_user (client_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE client ADD client_compte_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C744045519E5B62F FOREIGN KEY (client_compte_id) REFERENCES compte (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C744045519E5B62F ON client (client_compte_id)');
        $this->addSql('ALTER TABLE fos_user DROP FOREIGN KEY FK_957A647919EB6921');
        $this->addSql('DROP INDEX UNIQ_957A647919EB6921 ON fos_user');
        $this->addSql('ALTER TABLE fos_user DROP client_id');
    }
}
