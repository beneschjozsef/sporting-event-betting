<?php

// database/migrations/Version20210610000000.php

namespace Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210610000002 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create tables';
    }

    public function up(Schema $schema): void
    {

        $table = $schema->createTable('users');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('name', 'string', ['length' => 255]);
        $table->addColumn('email', 'string', ['length' => 255]);
        $table->addColumn('password', 'string', ['length' => 255]);
        $table->addColumn('api_token', 'string', ['length' => 80, 'notnull' => false]);
        $table->addColumn('created_at', 'datetime', ['notnull' => false]);
        $table->addColumn('updated_at', 'datetime', ['notnull' => false]);
        $table->setPrimaryKey(['id']);
        $table->addUniqueIndex(['email']);


        $table = $schema->createTable('events');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('title', 'string', ['length' => 255]);
        $table->addColumn('date', 'datetime');
        $table->addColumn('creator_id', 'integer');
        $table->setPrimaryKey(['id']);
        $table->addForeignKeyConstraint('users', ['creator_id'], ['id'], ['onDelete' => 'CASCADE']);


        $table = $schema->createTable('participants');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('name', 'string', ['length' => 255]);
        $table->addColumn('role', 'string', ['length' => 255]);
        $table->addColumn('description', 'text', ['notnull' => false]);
        $table->setPrimaryKey(['id']);

        // Events_Participants pivot table
        $eventParticipantTable = $schema->createTable('event_participants');
        $eventParticipantTable->addColumn('event_id', 'integer');
        $eventParticipantTable->addColumn('participant_id', 'integer');
        $eventParticipantTable->setPrimaryKey(['event_id', 'participant_id']);
        $eventParticipantTable->addForeignKeyConstraint('events', ['event_id'], ['id'], ['onDelete' => 'CASCADE']);
        $eventParticipantTable->addForeignKeyConstraint('participants', ['participant_id'], ['id'], ['onDelete' => 'CASCADE']);



        $table = $schema->createTable('teams');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('name', 'string', ['length' => 255]);
        $table->addColumn('description', 'text');
        $table->setPrimaryKey(['id']);


        $table = $schema->createTable('guesses');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('user_id', 'integer');
        $table->addColumn('event_id', 'integer');
        $table->addColumn('participant_id', 'integer');
        $table->setPrimaryKey(['id']);
        $table->addForeignKeyConstraint('users', ['user_id'], ['id'], ['onDelete' => 'CASCADE']);
        $table->addForeignKeyConstraint('events', ['event_id'], ['id'], ['onDelete' => 'CASCADE']);
        $table->addForeignKeyConstraint('participants', ['participant_id'], ['id'], ['onDelete' => 'CASCADE']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('guesses');
        $schema->dropTable('teams');
        $schema->dropTable('participants');
        $schema->dropTable('events');
        $schema->dropTable('users');
    }
}
