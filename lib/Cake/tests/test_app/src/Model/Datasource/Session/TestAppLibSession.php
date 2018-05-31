<?php
/**
 * Test suite app/Model/Datasource/Session session handler
 *
 */
namespace lib\Cake\Test\test_app\Model\Datasource\Session;



class TestAppLibSession implements SessionHandlerInterface {

	public function open() {
		return true;
	}

	public function close() {
	}

	public function read($id) {
	}

	public function write($id, $data) {
	}

	public function destroy($id) {
	}

	public function gc($expires = null) {
	}

}
