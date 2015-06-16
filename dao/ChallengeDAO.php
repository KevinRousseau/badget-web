<?php

require_once WWW_ROOT . 'dao' . DIRECTORY_SEPARATOR . 'DAO.php';

class ChallengeDAO extends DAO {
    
  public function selectAll() {
    $sql = "SELECT * 
    				FROM `ba_challenges`";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }    

	public function selectById($id) {
		$sql = "SELECT * 
						FROM `ba_challenges` 
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

	public function selectByDeviceIdAndChallengeId($device_id, $challenge_id) {
		$sql = "SELECT * 
						FROM `ba_challenges` 
						WHERE `device_id` = :device_id 
						AND `challenge_id` = :challenge_id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(':device_id', $device_id);
		$stmt->bindValue(':challenge_id', $challenge_id);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		if($result){
			return $result;
		}
		return [];
	}

	public function selectByDeviceId($device_id) {
		$sql = "SELECT * 
						FROM `ba_challenges` 
						WHERE `device_id` = :device_id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(':device_id', $device_id);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		if($result){
			return $result;
		}
		return [];
	}

	public function selectByChallengeId($challenge_id) {
		$sql = "SELECT * 
						FROM `ba_challenges` 
						WHERE `challenge_id` = :challenge_id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(':challenge_id', $challenge_id);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		if($result){
			return $result;
		}
		return [];
	}

	public function delete($id) {
		$sql = "DELETE 
						FROM `ba_challenges` 
						WHERE `id` = :id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(':id', $id);
		return $stmt->execute();
	}

	public function update($id, $data) {
		$sql = "UPDATE `ba_challenges` 
					SET `score` = :score
					WHERE `id` = :id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(':score', $data["score"]);
		$stmt->bindValue(':id', $id);
		if($stmt->execute()) {
			return $this->selectById($id);
		}
	}

	public function insert($data) {
		$errors = $this->getValidationErrors($data);
		if(empty($errors)) {
			$sql = "INSERT INTO `ba_challenges` (`device_id`, `score`, `challenge_id`) 
							VALUES (:device_id, :score, :challenge_id)";
			$stmt = $this->pdo->prepare($sql);
			$stmt->bindValue(':device_id', $data['device_id']);
			$stmt->bindValue(':score', $data['score']);
			$stmt->bindValue(':challenge_id', $data['challenge_id']);
			if($stmt->execute()) {
				$insertedId = $this->pdo->lastInsertId();
				return $this->selectById($insertedId);
			}
		}
		return ["error" => "challenge not inserted"];
	}

	public function getValidationErrors($data) {
		$errors = array();
		if(empty($data['device_id'])) {
			$errors['device_id'] = 'field device_id has no value';
		}
		if(empty($data['score'])) {
			$errors['score'] = 'field score has no value';
		}
		if(empty($data['challenge_id'])) {
			$errors['challenge_id'] = 'field challenge_id has no value';
		}
		return $errors;
	}

}