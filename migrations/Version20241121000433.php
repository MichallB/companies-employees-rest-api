<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241121000433 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__company AS SELECT id, name, nip, address, city, postcode FROM company');
        $this->addSql('DROP TABLE company');
        $this->addSql('CREATE TABLE company (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, nip VARCHAR(16) NOT NULL, address VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, post_code VARCHAR(16) NOT NULL)');
        $this->addSql('INSERT INTO company (id, name, nip, address, city, post_code) SELECT id, name, nip, address, city, postcode FROM __temp__company');
        $this->addSql('DROP TABLE __temp__company');
        $this->addSql('CREATE TEMPORARY TABLE __temp__employee AS SELECT id, company_id, name, surname, email, phonenumber FROM employee');
        $this->addSql('DROP TABLE employee');
        $this->addSql('CREATE TABLE employee (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, company_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone_number VARCHAR(16) DEFAULT NULL, CONSTRAINT FK_5D9F75A1979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO employee (id, company_id, name, surname, email, phone_number) SELECT id, company_id, name, surname, email, phonenumber FROM __temp__employee');
        $this->addSql('DROP TABLE __temp__employee');
        $this->addSql('CREATE INDEX IDX_5D9F75A1979B1AD6 ON employee (company_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__company AS SELECT id, name, nip, address, city, post_code FROM company');
        $this->addSql('DROP TABLE company');
        $this->addSql('CREATE TABLE company (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, nip VARCHAR(16) NOT NULL, address VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, postcode VARCHAR(16) NOT NULL)');
        $this->addSql('INSERT INTO company (id, name, nip, address, city, postcode) SELECT id, name, nip, address, city, post_code FROM __temp__company');
        $this->addSql('DROP TABLE __temp__company');
        $this->addSql('CREATE TEMPORARY TABLE __temp__employee AS SELECT id, company_id, name, surname, email, phone_number FROM employee');
        $this->addSql('DROP TABLE employee');
        $this->addSql('CREATE TABLE employee (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, company_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phonenumber VARCHAR(16) DEFAULT NULL, CONSTRAINT FK_5D9F75A1979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO employee (id, company_id, name, surname, email, phonenumber) SELECT id, company_id, name, surname, email, phone_number FROM __temp__employee');
        $this->addSql('DROP TABLE __temp__employee');
        $this->addSql('CREATE INDEX IDX_5D9F75A1979B1AD6 ON employee (company_id)');
    }
}
