<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PaymentTable extends Migration
{
	public function up()
	{
		$this->forge->addfield([
		'id' => [
		'type' => 'INT',
		'constraint' => 6,
		'unsigned' => true,
		'auto_increment' => true
		],
		'firstname' => [
		'type' => 'VARCHAR',
		'constraint' => 100
		],
		'lastname' => [
		'type' => 'VARCHAR',
		'constraint' => 100
		],
		'payment_id' => [
		'type' => 'VARCHAR',
		'constraint' => 255,
		'unique' => true
		],
		'amount' => [
		'type' => 'INT',
		'constraint' => 5
		],
		'address' => [
		'type' => 'VARCHAR',
		'constraint' => 255
		],
		'city' => [
		'type' => 'VARCHAR',
		'constraint' => 150
		],
		'phone' => [
		'type' => 'VARCHAR',
		'constraint' => 15
		],
		'email' => [
		'type' => 'VARCHAR',
		'constraint' => 255
		],
		'deleted_at' => [
		'type' => 'datetime',
		'null' => true
		],
		'updated_at' => [
		'type' => 'datetime'
		],
		'created_at' => [
		'type' => 'datetime'
		]
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('payments', true);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('payments', true);
	}
}