<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180328093519 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        /*Create authors table */
        $this->addSql('create table Authors (
                        id uuid not null,

                        full_name varchar(255) not null,
                        created_at timestamp not null,
                        modified_at timestamp not null,

                        primary key (id));');

        /*Insert random authors data */
        $this->addSql('insert into Authors (id, full_name, created_at, modified_at) values (
                        \'2cab326a-ab2f-4624-a6d7-2e1855fc5e4e\',
                        \'Jon Snow\',
                        \'2016-12-12T20:51:00+0000\',
                        \'2016-12-12T20:51:00+0000\');');

        $this->addSql('insert into Authors (id, full_name, created_at, modified_at) values (
                        \'9c99c399-4568-4079-960b-dbd333327b32\',
                        \'Arya Stark\',
                        \'2016-12-12T20:53:00+0000\',
                        \'2016-12-12T20:53:00+0000\');');

        $this->addSql('insert into Authors (id, full_name, created_at, modified_at) values (
                        \'95304003-31c8-4aa8-9dd6-d5af7810d621\',
                        \'Khal Drogo\',
                        \'2016-12-12T20:56:00+0000\',
                        \'2016-12-12T20:56:00+0000\');');

        /*Create posts table */
        $this->addSql('create table Posts (
                        id uuid not null,

                        title varchar(255) not null,
                        body text not null,
                        created_at timestamp not null,
                        modified_at timestamp not null,

                        author uuid not null references authors(id) on delete cascade,

                        primary key (id));');

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
