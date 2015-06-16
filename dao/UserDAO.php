<?php

require_once WWW_ROOT . 'dao' . DIRECTORY_SEPARATOR . 'DAO.php';

class UserDAO extends DAO {
    
  public function selectAll() {
    $sql = "SELECT * 
    				FROM `ba_users`";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }    

	public function selectById($id) {
		$sql = "SELECT * 
						FROM `ba_users` 
						WHERE `id` = :id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(':id', $id);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		if($result){
			return $result;
		}
		return [];
	}	

	public function selectByFacebookId($facebook_id) {
		$sql = "SELECT * 
						FROM `ba_users` 
						WHERE `facebook_id` = :facebook_id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(':facebook_id', $facebook_id);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		if($result){
			return $result;
		}
		return [];
	}

	public function selectByDeviceId($device_id) {
		$sql = "SELECT * 
						FROM `ba_users` 
						WHERE `device_id` = :device_id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(':device_id', $device_id);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		if($result){
			return $result;
		}
		return [];
	}

	public function delete($id) {
		$sql = "DELETE 
						FROM `ba_users` 
						WHERE `id` = :id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(':id', $id);
		return $stmt->execute();
	}

	public function insertWithFacebookId($data) {
		$errors = $this->getValidationErrorsOnInsertWithFacebookId($data);
		if(empty($errors)) {
			$sql = "INSERT INTO `ba_users` (`facebook_id`, `name`, `missing`, `device_id`) 
							VALUES (:facebook_id, :name, :missing, :device_id)";
			$stmt = $this->pdo->prepare($sql);
			$stmt->bindValue(':facebook_id', $data['facebook_id']);
			$stmt->bindValue(':name', $data['name']);
			$stmt->bindValue(':missing', 0);
			$stmt->bindValue(':device_id', $data['device_id']);
			if($stmt->execute()) {
				$insertedId = $this->pdo->lastInsertId();
				return $this->selectById($insertedId);
			}
		}
		return ["error" => "Facebook user not inserted"];
	}

	public function insertWithoutFacebookId($data) {
		$errors = $this->getValidationErrorsOnInsertWithoutFacebookId($data);
		if(empty($errors)) {
			$sql = "INSERT INTO `ba_users` (`missing`, `device_id`) 
							VALUES (:missing, :device_id)";
			$stmt = $this->pdo->prepare($sql);
			$stmt->bindValue(':missing', 0);
			$stmt->bindValue(':device_id', $data['device_id']);
			if($stmt->execute()) {
				$insertedId = $this->pdo->lastInsertId();
				return $this->selectById($insertedId);
			}
		}
		return ["error" => "User not inserted"];
	}

	public function updateToFacebookUser($id, $data) {
		$errors = $this->getValidationErrorsOnUpdateToFacebookUser($data);
		if(empty($errors)) {
			$sql = "UPDATE `ba_users` 
						SET `facebook_id` = :facebook_id,
								`name` = :name
						WHERE `id` = :id";
			$stmt = $this->pdo->prepare($sql);
			$stmt->bindValue(':facebook_id', $data["facebook_id"]);
			$stmt->bindValue(':name', $data["name"]);
			$stmt->bindValue(':id', $id);
			if($stmt->execute()) {
				return $this->selectByFacebookId($id);
			}
		}
		return ["error" => "User not updated to Facebook user"];
	}

	public function updateMissingByFacebookId($id, $data) {
		$sql = "UPDATE `ba_users` 
						SET `missing` = :missing,
								`latitude` = :latitude,
								`longitude` = :longitude
						WHERE `facebook_id` = :id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(':missing', $data["missing"]);
		$stmt->bindValue(':latitude', $data["latitude"]);
		$stmt->bindValue(':longitude', $data["longitude"]);
		$stmt->bindValue(':id', $id);
		if($stmt->execute()) {
			return $this->selectByFacebookId($id);
		}
		return ["error" => "Missing status not updated"];
	}

	public function getValidationErrorsOnInsertWithFacebookId($data) {
		$errors = array();
		if(empty($data['facebook_id'])) {
			$errors['facebook_id'] = 'field facebook_id has no value';
		}
		if(empty($data['name'])) {
			$errors['name'] = 'field name has no value';
		}
		if(empty($data['device_id'])) {
			$errors['device_id'] = 'field device_id has no value';
		}
		return $errors;
	}

	public function getValidationErrorsOnInsertWithoutFacebookId($data) {
		$errors = array();
		if(empty($data['device_id'])) {
			$errors['device_id'] = 'field device_id has no value';
		}
		return $errors;
	}

	public function getValidationErrorsOnUpdateToFacebookUser($data) {
		$errors = array();
		if(empty($data['facebook_id'])) {
			$errors['facebook_id'] = 'field facebook_id has no value';
		}
		if(empty($data['name'])) {
			$errors['name'] = 'field name has no value';
		}
		return $errors;
	}

}