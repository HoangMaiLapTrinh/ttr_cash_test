<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumn extends Migration
{
    public function up()
    {
        $this->forge->addColumn('system_settings', [
            'options' => [
                'type' => 'TEXT',
                'null' => true
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('system_settings', 'options');
    }
}
