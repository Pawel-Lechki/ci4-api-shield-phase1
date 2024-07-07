<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStudentsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            "id" => [
                "type" => "INT",
                "constraint" => 5,
                "auto_increment" => true,
                "unsigned" => true,
            ],
            "name" => [
                "type" => "VARCHAR",
                "constraint" => 120,
                "null" => true
            ],
            "email" => [
                "type" => "VARCHAR",
                "constraint" => 50,
                "null" => true
            ],
            "phone" => [
                "type" => "VARCHAR",
                "constraint" => 50,
                "null" => true
            ],
            "profile_image" => [
                "type" => "VARCHAR",
                "constraint" => 180,
                "null" => true
            ]
        ]);

        $this->forge->addPrimaryKey("id");

        $this->forge->createTable('students');
    }

    public function down()
    {
        $this->forge->dropTable('students');
    }
}
