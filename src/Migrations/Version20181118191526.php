<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181118191526 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_B3BA5A5AF603EE73');
        $this->addSql('CREATE TEMPORARY TABLE __temp__products AS SELECT id, vendor_id, name, price FROM products');
        $this->addSql('DROP TABLE products');
        $this->addSql('CREATE TABLE products (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, restaurant_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, price DOUBLE PRECISION NOT NULL, CONSTRAINT FK_B3BA5A5AB1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurants (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO products (id, restaurant_id, name, price) SELECT id, vendor_id, name, price FROM __temp__products');
        $this->addSql('DROP TABLE __temp__products');
        $this->addSql('CREATE INDEX IDX_B3BA5A5AB1E7706E ON products (restaurant_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_B3BA5A5AB1E7706E');
        $this->addSql('CREATE TEMPORARY TABLE __temp__products AS SELECT id, restaurant_id, name, price FROM products');
        $this->addSql('DROP TABLE products');
        $this->addSql('CREATE TABLE products (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, vendor_id INTEGER NOT NULL)');
        $this->addSql('INSERT INTO products (id, vendor_id, name, price) SELECT id, restaurant_id, name, price FROM __temp__products');
        $this->addSql('DROP TABLE __temp__products');
        $this->addSql('CREATE INDEX IDX_B3BA5A5AF603EE73 ON products (vendor_id)');
    }
}
