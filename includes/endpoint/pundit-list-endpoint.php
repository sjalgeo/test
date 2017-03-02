<?php

namespace SBTechTest\Endpoint;

use SBTechTest\Database;

class Pundit_List_Endpoint {

	protected $root_directory;
	protected $data;

	public function __construct( $root_directory ) {
		$this->root_directory = $root_directory;
	}

	public function run() {
		$db = new Database($this->root_directory);
		$db->fetchAll('pundits');
		$this->data = $db->get_last_result();
	}

	public function get_response() {
		return $this->data;
	}
}