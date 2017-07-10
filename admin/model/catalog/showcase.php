<?php
class ModelCatalogShowcase extends Model {
	public function addShowcase($data) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "showcase` SET title = '" . $this->db->escape($data['title']) . "', sort_order = '" . (int)$data['sort_order'] . "', category_id = '" . (int)$data['category'] . "'");

		$showcase_id = $this->db->getLastId();

		if (isset($data['showcase_command'])) {
			foreach ($data['showcase_command'] as $command) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "showcase_command SET showcase_id = '" . (int)$showcase_id . "', command = '" . $this->db->escape($command['command']) . "', result = '" . $this->db->escape($command['result']) . "', is_edit = " . (int)$command['is_edit'] . ", sort_order=" . (int)$command['sort_order']);
			}
		}

		return $showcase_id;
	}

	public function editShowcase($showcase_id, $data) {
		$this->db->query("UPDATE `" . DB_PREFIX . "showcase` SET title = '" . $this->db->escape($data['title']) . "', sort_order = '" . (int)$data['sort_order'] . "', category_id = '" . (int)$data['category'] . "' WHERE showcase_id = '" . (int)$showcase_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "showcase_command WHERE showcase_id = '" . (int)$showcase_id . "'");

		if (isset($data['showcase_command'])) {
			foreach ($data['showcase_command'] as $command) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "showcase_command SET showcase_id = '" . (int)$showcase_id . "', command = '" . $this->db->escape($command['command']) . "', result = '" . $this->db->escape($command['result']) . "', is_edit = " . (int)$command['is_edit'] . ", sort_order=" . (int)$command['sort_order']);
			}
		}
	}

	public function deleteShowcase($showcase_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "showcase` WHERE showcase_id = '" . (int)$showcase_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "showcase_command WHERE showcase_id = '" . (int)$showcase_id . "'");
	}

	public function getShowcase($showcase_id) {
		$query = $this->db->query("SELECT o.*, od.command, od.result, od.is_edit FROM `" . DB_PREFIX . "showcase` o LEFT JOIN " . DB_PREFIX . "showcase_command od ON (o.showcase_id = od.showcase_id) WHERE o.showcase_id = '" . (int)$showcase_id . "'");
		
		$result = array(
			'title' => $query->row['title'],
			'sort_order' => $query->row['sort_order'],
			'commands' => array(),
                        'category_id' => $query->row['category_id']
		);
		foreach($query->rows as $row){
			$result[$row['showcase_id']]['commands'][] = array(
				'command' => $row['command'],
				'result' => $row['result'],
				'is_edit' => $row['is_edit']
			);
		}
		
		return $result;
	}

	public function getShowcases() {
		$sql = "SELECT * FROM `" . DB_PREFIX . "showcase`";
		
		$query = $this->db->query($sql);
		
		return $query->rows;
	}

	public function getShowcaseCommands($showcase_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "showcase_command WHERE showcase_id = '" . (int)$showcase_id . "'");

		return $query->rows;
	}

	public function getTotalShowcases() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "showcase`");

		return $query->row['total'];
	}
}