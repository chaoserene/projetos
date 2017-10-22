<?php

require_once('app.config.php');

/**
* User class
*/
class User extends MysqliDb {
	private $usr_id;
	private $user;
	private $password;
	private $email;
	private $register_date;

	public function __construct($user = null, $password = null, $email = null, $register_date = null) {
		$db = new MysqliDb;
		$this->setUser($user);
		$this->setPassword($password);
		$this->setEmail($email);
		$this->setRegisterDate($register_date);
		$this->getUserData();
	}

	public function getUserId() {
		return $this->usr_id;
	}

	public function getUser() {
		return $this->user;
	}

	public function getPassword() {
		return $this->password;
	}

	public function getEmail() {
		return $this->email;
	}

	public function getRegisterDate() {
		return $this->register_date;
	}

	public function getStatus() {
		return $this->status;
	}

	public function setUsrId($usr_id) {
		$this->usr_id = $usr_id;
	}

	public function setUser($user) {
		$this->user = $user;
	}

	public function setPassword($password) {
		$this->password = password_hash($password, PASSWORD_DEFAULT);
	}

	public function setEmail($email) {
		$this->email = $email;
	}

	public function setStatus($status) {
		$this->status = $status;
	}

	public function setRegisterDate($register_date) {
		$this->register_date = $register_date;
	}

	public function isUserRegistered() {
		if(empty($this->getEmail())) return false;

		try {
			$db->connect();
			$db->where('email', $this->getEmail(), 'LIKE');
			$user = $db->getone('users');
			$db->disconnect();
		} catch(Exception $e) {
			//don't do anything with my exceptions for now
		}

		return (!empty($user)) ? true : false;
	}

	public function registerUser() {
		if(empty($this->getUser()) || empty($this->getEmail()) || empty($this->getPassword()) || empty($this->getRegisterDate())) return false;

		try {
			$data = array(
				'user' => $this->getUser(),
				'password' => $this->getPassword(),
				'email' => $this->getEmail(),
				'register_date' => $this->getRegisterDate()
			);
			$db->connect();
			$db->insert('users', $data);
			$db->disconnect();
		} catch(Exception $e) {
			return false;
		}

		return true;
	}

	public function getUserData() {
		if(empty($this->getEmail())) return false;

		try {
			$db->connect();
			$db->where('email', $this->getEmail(), 'LIKE');
			$user = $db->get('users', 1, array('usr_id', 'user', 'email', 'password', 'status', 'register_data'));
			$db->disconnect();

		} catch(Exception $e) {
			return false;
		}
		if(!empty($user)) {
			$this->setUsrId($user['usr_id']);
			$this->setUser($user['user']);
			$this->setEmail($user['email']);
			$this->setPassword($user['password']);
			$this->setStatus($user['status']);
			$this->setRegisterDate($user['register_date']);
		}

		return true;
	}

	public function inactivateUser() {
		if(empty($this->getUserId())) return false;

		try {
			$db->where('usr_id', $this->getUserId());
			$db->update('users', array('status' => 0));
			$this->setStatus(0);
		} catch (Exception $e) {
			return false;
		}
		return true;
	}

	public function activateUser() {
		if(empty($this->getUserId())) return false;

		try {
			$db->where('usr_id', $this->getUserId());
			$db->update('users', array('status' => 1));
			$this->setStatus(1);
		} catch (Exception $e) {
			return false;
		}
		return true;
	}

	public function updateEmail($email) {
		if(empty($this->getUserId()) || empty($email)) return false;

		try {
			$db->where('usr_id', $this->getUserId());
			$db->update('users', array('email' => $email))	
			$this->setEmail($email);
		} catch (Exception $e) {
			return false;
		}
		return true;
	}

	public function updatePassword($password) {
		if(empty($this->getUserId()) || empty($password)) return false;

		try {
			$db->where('usr_id', $this->getUserId());
			$db->update('users', array('password' => password_hash($password, PASSWORD_DEFAULT)));
			$this->setPassword($password);
		} catch (Exception $e) {
			return false;
		}
		return true;
	}


}