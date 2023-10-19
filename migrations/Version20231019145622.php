<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231019145622 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    /**
     * 
     * @param Doctrine\DBAL\Schema\Schema $schema
     * @return void
     */
    public function up(Schema $schema): void
    {
      $schema->  
        
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE INDEX IDX_527EDB25DE12AB56 ON task (created_by)');
        $this->addSql('ALTER TABLE task_list ADD CONSTRAINT FK_377B6C63DE12AB56 FOREIGN KEY (created_by) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_377B6C63DE12AB56 ON task_list (created_by)');
        $this->addSql('ALTER TABLE task CHANGE tasklist_id tasklist_id BIGINT DEFAULT NULL');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25FF3475DB FOREIGN KEY (tasklist_id) REFERENCES task_list (id)');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25DE12AB56 FOREIGN KEY (created_by) REFERENCES user (id)');
        
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE task_list DROP FOREIGN KEY FK_377B6C63DE12AB56');
        $this->addSql('DROP INDEX IDX_377B6C63DE12AB56 ON task_list');
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB25FF3475DB');
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB25DE12AB56');
        $this->addSql('DROP INDEX IDX_527EDB25DE12AB56 ON task');
        $this->addSql('ALTER TABLE task CHANGE tasklist_id tasklist_id BIGINT DEFAULT NULL');
    }
}
