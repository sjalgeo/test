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
		$this->db = new Database( $this->root_directory );

		$this->parse_endpoint();
	}

	protected function parse_endpoint() {

		$parts = explode( '/', $this->request_uri );

		if ( isset( $parts[1] ) ) {
			$this->endpoint = $parts[1];
		}
	}

	protected function pundits_list() {
		$this->db->fetchAll('pundits');
		$this->response = array(
			'status' => 'success',
			'data' => $this->db->get_last_result()
		);
	}

	protected function pundits_create() {

		if ( ! isset( $_POST['firstname'] ) OR ! isset( $_POST['surname'] ) ) {
			$this->failure_response();
			return;
		}

		$data = array(
			'firstname' => htmlspecialchars( $_POST['firstname'] ),
			'surname'   => htmlspecialchars( $_POST['surname'] )
		);

		$this->db->create( 'pundits', $data );
		$this->response = array(
			'status'    => 'success',
		);
	}

	protected function pundits_delete() {

		if ( ! isset($_POST['id'] ) ) {

			$this->response = array(
				'status'    => 'error',
				'code'      => 'missing-parameter',
				'message'   => 'No pundit ID was provided.'
			);

			return;
		}

		// do some safety shit.
		$id = intval( $_POST['id'] );
		$this->db->delete('pundits', $id);

		$error = $this->db->get_last_error();

		if ( $error ) {
			$this->response = array(
				'status'    => 'failed',
				'code'      => $error
			);
		} else {
			$this->response = array(
				'status'    => 'success'
			);
		}
	}

	protected function pundits_update() {
		// do some safety shit.

		$id = intval( $_POST['id'] );
		$data = array(
			'firstname' => htmlspecialchars( $_POST['firstname'] ),
			'surname'   => htmlspecialchars( $_POST['surname'] )
		);

		$this->db->update( 'pundits', $id, $data );

		$this->response = array(
			'status'    => 'success'
		);
	}

	protected function pundits_reset() {
		$this->db->reset();

		$this->response = array(
			'status'    => 'success'
		);
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

		if ( ! in_array( $_SERVER['REQUEST_METHOD'], array('GET', 'POST') ) ) {
			$this->response = array(
				'status'    => 'error',
				'code'      => 'invalid-method',
				'message'   => 'Invalid HTTP Method.'
			);
			return;
		}

		switch ( $this->endpoint ) {

			case 'list':
				$this->pundits_list();
				break;

			case 'update':
				$this->pundits_update();
				break;

			case 'delete':
				$this->pundits_delete();
				break;

			case 'create':
				$this->pundits_create();
				break;

			case 'reset':
				$this->pundits_reset();
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