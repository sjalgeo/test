<?php

namespace SBTechTest;

use SBTechTest\Endpoint\Pundit_List_Endpoint;

class API_Server {

	protected $request_uri;
	protected $response;
	protected $endpoint = false;

	public function __construct( $request_uri, $root_directory ) {
		$this->request_uri = $request_uri;
		$this->root_directory = $root_directory;

		$this->match_path();
	}

	protected function match_path() {

		$parts = explode( '/', $this->request_uri );

		if ( isset( $parts[1] ) ) {
			$this->endpoint = $parts[1];
		}
	}

	protected function pundits_list() {
		$this->response = array('pundit list');

		$pundits = new Pundit_List_Endpoint( $this->root_directory );
		$pundits->run();
		$this->response = $pundits->get_response();
	}

	/**
	 * Failure response returned to anybody without an matching path.
	 */
	protected function failure_response() {
		$this->response = array(
			'status'    => 'error',
			'code'      => 'invalid-request',
			'message'   => 'This request was invalid please check your things.'
		);
	}

	public function run() {

		switch ( $this->endpoint ) {
			case 'pundits':
				$this->pundits_list();
				break;
			default:
				$this->failure_response();
		}

		$this->output();
	}

	public function output() {
		header('Content-Type: application/json');
		echo json_encode( $this->response );
		exit;
	}
}