<?php

namespace SBTechTest\Endpoint;

class Pundit_List_Endpoint {

	protected $root_directory;
	protected $data;

	public function __construct( $root_directory ) {
		$this->root_directory = $root_directory;
	}

	public function run() {
		$data =  file_get_contents( $this->root_directory . '/pundits.json' );
		$this->data = json_decode( $data );
	}

	public function get_response() {
		return $this->data;
	}
}