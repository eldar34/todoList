<?php

use Phinx\Migration\AbstractMigration;

class TasksTable extends AbstractMigration
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
        $users = $this->table('tasks');
        $users->addColumn('name', 'string', ['limit' => 250])
              ->addColumn('email', 'string', ['limit' => 250])
              ->addColumn('task', 'string', ['limit' => 250])
              ->addColumn('status', 'string', ['default' =>  'New'])
              ->addColumn('updated_by', 'integer', ['default' => 0])             
              ->save();
    }

    public function down()
    {
        $this->table('tasks')->drop()->save();
    }
}
