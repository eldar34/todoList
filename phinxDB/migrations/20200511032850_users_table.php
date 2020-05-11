<?php

use Phinx\Migration\AbstractMigration;

class UsersTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    addCustomColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Any other destructive changes will result in an error when trying to
     * rollback the migration.
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    // public function change()
    // {
        

    // }
    public function up()
    {
        $users = $this->table('bee_users');
        $users->addColumn('name', 'string', ['limit' => 250])
              ->addColumn('surename', 'string', ['limit' => 250])
              ->addColumn('email', 'string', ['limit' => 250])
              ->addColumn('password', 'string', ['limit' => 250])
              ->addColumn('online', 'datetime')
              ->addColumn('last_act', 'datetime')
              ->addColumn('salt', 'string', ['limit' => 250])
              ->save();
    }

    public function down()
    {
        $this->table('bee_users')->drop()->save();
    }
}
