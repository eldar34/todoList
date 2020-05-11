<?php


use Phinx\Seed\AbstractSeed;

class UserSeeder extends AbstractSeed
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
                'surename'    => 'Smith',
                'email'    => 'admin',
                'password'    => '9a91ddbc582ba5146d85af5d0dddcef5',
                'online'    => date('Y-m-d H:i:s'),
                'last_act'    => date('Y-m-d H:i:s'),                
                'salt' => '1588137382'
            ]
        ];

        $posts = $this->table('bee_users');
        $posts->insert($data)
              ->saveData();
    }
}
