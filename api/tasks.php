<?php
require_once 'credentials.php';


try{
    $conn_string = "mysql:host=".$dbserver.";dbname=".$db;
	$dbh= new PDO($conn_string, $dbusername, $dbpassword);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(Exception $e){
	//Database issues were encountered
    http_response_code(504);
    echo "Database timeout";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == "GET") {
	try {
			$sql = "SELECT * FROM doList";
			$stmt = $dbh->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			$final = [];
			foreach ($result as $task) {
				// Rename the keys
				// listID -> listID
				// listItem -> taskName
				// finishDate -> taskDate
				// complete -> completed
				$task['taskName'] = $task['listItem'];
				$task['taskDate'] = $task['finishDate'];
				$task['completed'] = $task['complete'];

				// Delete the old keys
				unset($task['listItem'], $task['finishDate'], $task['complete']);

				// Make completed a boolean
				$task['completed'] = $task['completed'] ? true : false;

				// Store the updated task
				$final[] = $task;
			}

			echo json_encode($final);
			exit();
		} catch (PDOException $e) {
			http_response_code(500);
			echo 'cannot get tasks';
			exit();
		}
}
