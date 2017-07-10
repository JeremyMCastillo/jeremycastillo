<?php
class ModelCatalogShowcase extends Model {
	public function getShowcases() {
		$sql = "SELECT * FROM `" . DB_PREFIX . "showcase` ORDER BY sort_order";
		
		$query = $this->db->query($sql);
		
		$result = array();
		foreach($query->rows as $row){
			$result[$row['category_id']] = array(
				'commands' => $this->getShowcaseCommands($row['showcase_id']),
                                'title' => $row['title']
			);
		}
		
		return $result;
	}
	
	public function getShowcaseCommands($showcase_id){
		$sql = "SELECT * FROM `" . DB_PREFIX . "showcase_command` WHERE showcase_id=" . (int)$showcase_id . " ORDER BY sort_order";
		
		$query = $this->db->query($sql);
		
		return $query->rows;
	}
}
?>