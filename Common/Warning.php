<?php
			if (file_exists("task_management_db.sql")) {
				$sqlFilePath = "task_management_db.sql";
			} else {
				$sqlFilePath = "../task_management_db.sql";
			}
			
			$sqlFileContent = file_get_contents($sqlFilePath);
			preg_match_all('/CREATE TABLE `([^`]+)` \((.*?)\)[^)]+;/s', $sqlFileContent, $matches, PREG_SET_ORDER);
			$fileTables = [];
			
			foreach ($matches as $match) {
				$tableName = $match[1];
				$columns = $match[2];
				preg_match_all('/`([^`]+)`/', $columns, $columnMatches);
				$fileTables[$tableName] = $columnMatches[1];				
			}
			
			$stmt = $conn->query("SHOW TABLES");
			$dbTables = [];
			
			while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
				$tableName = $row[0];
				$columnsStmt = $conn->query("DESCRIBE `$tableName`");
				$dbTables[$tableName] = [];
				while ($column = $columnsStmt->fetch(PDO::FETCH_ASSOC)) {
					$dbTables[$tableName][] = $column['Field'];
				}
			}
			
			$errors = 0;
            $table=0;
            $field=0;
			
			foreach ($fileTables as $tableName => $fileColumns) {
				if (!isset($dbTables[$tableName])) {
					$errors++;
                    $table++;
					continue;
				}
			
				foreach ($fileColumns as $columnName) {
					
					if (!in_array($columnName, $dbTables[$tableName])) {
						$errors++;
                        $field++;
					}
				}
			}
			if($errors!=0){
                $tr="Table";
                if($table>1){
                    $tr="Tables";
                }
                $fi="Field";
                if($field>1){
                    $fi="Fields";
                }
                if($field!=0 && $table!=0){
                    $msg="$table $tr & $field $fi";
                }else if($field!=0){
                    $msg="$field $fi";
                }else{
                    $msg="$table $tr";
                }
                echo "<div style='padding:15px;margin:15px 0;border-radius:10px;background-color:red;color:white;display:flex;align-items:center;justify-content:center;gap:10px'>
                <ion-icon name='warning-outline' style='font-size:26px;'></ion-icon> Warning: $msg are Missing Data Found in Database <ion-icon name='warning-outline' style='font-size:26px;'></ion-icon>
                </div>";
            }
?>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>