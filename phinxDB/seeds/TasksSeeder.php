<?php


use Phinx\Seed\AbstractSeed;

class TasksSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run()
    {
        $data = [
            [
                'name'    => 'John',
                'email'    => 'john@mail.com',
                'task'    => 'first'
            ],
            [
                'name'    => 'Mary',
                'email'    => 'mary@mail.com',
                'task'    => 'second'
            ],
            [
                'name'    => 'Bany',
                'email'    => 'bany@mail.com',
                'task'    => 'third'
            ],
            [
                'name'    => 'Any',
                'email'    => 'any@mail.com',
                'task'    => 'Evil); DROP TABLE drop_table;--'
            ],
        ];

        $posts = $this->table('tasks');
        $posts->insert($data)
              ->saveData();
    }
}
