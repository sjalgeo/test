<?php

namespace SBTechTest;

class Database {

	private $last_result = null;

	public function __construct($root_directory) {
		$this->root_directory = $root_directory;
	}

	public function reset() {
		$data = '[{"firstname":"Jeff","surname":"Stelling","id":"1"},{"firstname":"Chris","surname":"Kamara","id":"2"},{"firstname":"Alex","surname":"Hammond","id":"3"},{"firstname":"Jim","surname":"White","id":"4"},{"firstname":"Natalie","surname":"Sawyer","id":"5"}]';
		file_put_contents( $this->root_directory.'pundits.json', $data );
	}

	public function fetchAll( $table ) {
		$data =  file_get_contents( $this->root_directory . '/' . $table . '.json' );
		$this->last_result = json_decode($data, true);
	}

	public function fetch( $table, $id ) {
		$this->fetchAll($table);

		// This wouldn't scale well, but neither would a flat file database :)
		foreach ($this->get_last_result() as $pundit) {
			if ( isset($pundit['id']) AND intval($pundit['id']) === $id ) {
				$this->last_result = $pundit;
				return;
			}
		}

		$this->last_result = null;
	}

	public function update( $table, $id, $update_data ) {

		// cleanse the post data.

		$this->fetch($table, $id);
		$previous_record = $this->get_last_result();

		$new_record = $previous_record;

		foreach ( $update_data as $property => $value ) {

			if ( isset( $new_record[$property] ) ){
				$new_record[$property] = $value;
			}
		}

		$this->fetchAll($table);
		$all = $this->get_last_result();

		foreach ($all as $key => $row) {
			if ( isset($row['id']) AND intval($row['id']) === $id ) {
				$all[$key] = $new_record;
			}
		}

		$this->commit($table, $all);
	}

	public function delete( $table, $id ) {

		$this->fetchAll($table);
		$all = $this->get_last_result();

		foreach ($all as $key => $row) {
			if ( isset($row['id']) AND intval($row['id']) === $id ) {
				unset($all[$key]);
			}
		}

		$this->commit($table, $all);
	}

	protected function commit($table, $data) {
		$db_file = $this->root_directory.'pundits.json';
		file_put_contents( $db_file, json_encode( array_values( $data ) ) );
	}

	public function get_last_result() {
		return $this->last_result;
	}
}