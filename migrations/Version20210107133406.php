<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210107133406 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tricks ADD url_path VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E1D902C15E237E06 ON tricks (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E1D902C1150042B7 ON tricks (url_path)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_E1D902C15E237E06 ON tricks');
        $this->addSql('DROP INDEX UNIQ_E1D902C1150042B7 ON tricks');
        $this->addSql('ALTER TABLE tricks DROP url_path');
    }
}
