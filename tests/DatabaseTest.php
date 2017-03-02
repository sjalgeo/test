<?php

namespace SBTechTest\Tests\API;

use SBTechTest\Database;


class DatabaseTest extends \PHPUnit_Framework_TestCase{

	private $root_directory;
	private $db;

	public function setUp() {
		$this->root_directory = ROOT_DIR;
		$this->db = new Database( $this->root_directory );
		$this->db->reset();
	}

	public function testReadAllFromDatabase() {

		$this->db->fetchAll('pundits');
		$data = $this->db->get_last_result();

		foreach ($data as $pundit){
			$this->assertArrayHasKey( 'firstname', $pundit );
			$this->assertArrayHasKey( 'surname', $pundit );
		}

		$this->assertCount(5, $data);
	}

	public function testReadSingleFromDatabase() {
		$this->db->fetch( 'pundits', 3 );
		$pundit = $this->db->get_last_result();

		$this->assertArrayHasKey( 'firstname', $pundit );
		$this->assertArrayHasKey( 'surname', $pundit );
	}

	public function testMissingFromDatabase() {
		$this->db->fetch( 'pundits', 33 );
		$pundit = $this->db->get_last_result();

		$this->assertNull($pundit);
	}

	public function testUpdate() {

		$data = array(
			'firstname' => 'Andy',
			'surname'   => 'Hinchcliffe'
		);

		$this->db->update( 'pundits', 3, $data );

		$this->db->fetch('pundits', 3);

		$pundit = $this->db->get_last_result();

		$this->assertEquals( 'Andy', $pundit['firstname'] );
		$this->assertEquals( 'Hinchcliffe', $pundit['surname'] );
	}

	public function testDelete() {

		// Record must exist to begin with.
		$this->db->fetch('pundits', 3);
		$pundit = $this->db->get_last_result();

		$this->assertArrayHasKey( 'firstname', $pundit );
		$this->assertArrayHasKey( 'surname', $pundit );

		// Delete record.
		$this->db->delete( 'pundits', 3 );

		// Record no longer exists.
		$this->db->fetch('pundits', 3);
		$pundit = $this->db->get_last_result();
		$this->assertNull($pundit);
	}
}