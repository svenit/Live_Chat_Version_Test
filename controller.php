<?php

 include("connect.php");
 error_reporting(0);
 session_start();
 $session = session_id();
 $time = time();

 switch ($_POST['action']) {
     case 'display':
            $result = $connect->prepare("SELECT * FROM comment");
            $result->execute();
            $result->setFetchMode(PDO::FETCH_OBJ);
            foreach ($result as $rows) {
              ?>
                <p><?php echo $rows->content . " - " . timeAgo("$rows->time"); ?></p>
              <?php
           }
     break;
     case 'send':
            $message = htmlspecialchars(addslashes($_POST['message']));
            if(!trim($message) || $message == ""){
                return false;
            }
            else{
                $result = $connect->prepare("INSERT INTO comment(content) VALUES('{$message}')");
                $result->execute();
            }
     break;
     case 'userOnline':
            $remake = $connect->prepare("SELECT * FROM tododb WHERE session_key = '{$session}' ");
            $remake->execute();
            $count = $remake->rowCount();
            if($count == NULL){
                $add = $connect->prepare("INSERT INTO tododb(session_key,time) VALUES('{$session}','{$time}')");
                $add->execute();
             }
            else{
                $update = $connect->prepare("UPDATE tododb SET time='{$time}' WHERE session_key='{$session}' ");
                $update->execute();
            }
            $countUser = $connect->prepare("SELECT * FROM tododb");
            $countUser->execute();
            echo $countUser = $countUser->rowCount();
            $delete = $connect->prepare("DELETE FROM tododb WHERE time < $time-10");
            $delete->execute();
            $connect = NULL;
     break;
 }
?>