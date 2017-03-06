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

	public function testCreate() {
		$this->db->fetchAll( 'pundits' );
		$all_pundits = $this->db->get_last_result();

		$ids_in_use = array_map( function ( $pundit ) {
			return $pundit['id'];
		}, $all_pundits);

		$new_pundit = array(
			'firstname' => 'Tim',
			'surname'   => 'Cahill'
		);

		$this->db->create( 'pundits', $new_pundit );

		$new_id = $this->db->get_last_id();

		$this->assertFalse( in_array( $new_id, $ids_in_use ) );

		$this->db->fetch( 'pundits', $new_id );
		$new_pundit = $this->db->get_last_result();

		$this->assertEquals( $new_pundit['firstname'], 'Tim' );
		$this->assertEquals( $new_pundit['surname'], 'Cahill' );

		$this->db->fetchAll( 'pundits' );
		$all_pundits = $this->db->get_last_result();

		$this->assertEquals( count( $all_pundits ), 6 );
	}

	public function tearDown() {
		$this->db->reset();
	}
}