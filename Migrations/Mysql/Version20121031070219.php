<?php
namespace TYPO3\Flow\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
	Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20121031070219 extends AbstractMigration {

	/**
	 * @param Schema $schema
	 * @return void
	 */
	public function up(Schema $schema) {
			// this up() migration is autogenerated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");
		
		$this->addSql("ALTER TABLE witte_kanban_domain_model_ticket ADD board VARCHAR(40) DEFAULT NULL");
		$this->addSql("ALTER TABLE witte_kanban_domain_model_ticket ADD CONSTRAINT FK_927A49B358562B47 FOREIGN KEY (board) REFERENCES witte_kanban_domain_model_board (persistence_object_identifier)");
		$this->addSql("CREATE INDEX IDX_927A49B358562B47 ON witte_kanban_domain_model_ticket (board)");
	}

	/**
	 * @param Schema $schema
	 * @return void
	 */
	public function down(Schema $schema) {
			// this down() migration is autogenerated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");
		
		$this->addSql("ALTER TABLE witte_kanban_domain_model_ticket DROP FOREIGN KEY FK_927A49B358562B47");
		$this->addSql("DROP INDEX IDX_927A49B358562B47 ON witte_kanban_domain_model_ticket");
		$this->addSql("ALTER TABLE witte_kanban_domain_model_ticket DROP board");
	}
}

?>