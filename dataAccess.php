<?php
include 'connection.php';
header("Access-Control-Allow-Origin: *");


 switch ($_GET['op']) {   
    case 1:
    //login
       $sql="SELECT * FROM tbl_user WHERE tbl_user_username='".$_GET['user']."'";
 
        $result=$conn->query($sql);

            if ($result->num_rows > 0) {
                // oupsut ssata sf each row
                while($row = $result->fetch_assoc()) {
                    if($row["tbl_user_password"]==$_GET['pass']){
                        echo $row["tbl_user_id"];
                    //echo json_encode($row);
                    }else{
                        echo "passerror";
                    }
                }
            } else {
            echo "usererror";
            }
         break;
    case 2:
    //nuevo usuario
       $sql="INSERT INTO tbl_user VALUES (NULL, '".$_GET['user']."', '".$_GET['pass']."')";
 
        $result=$conn->query($sql);
            if ($result!=1) {
                // oupsuss ssata of each row
                    echo "error";
            } else {
                        echo "success";
            }
         break;
     case 3:
    //nuevo canal (params name, user)
       $sql="INSERT INTO tbl_canal  VALUES (NULL, '".$_GET['name']."', '".$_GET['user']."')";
 
        $result=$conn->query($sql);
            if ($result!=1) {
                // oupsuss ssata of each row
                    echo "error";
            } else {
                        echo "success";
            }
         break;
 
     case 4:
    //registrar usuario en canal (params user & channel)
       $sql="INSERT INTO tbl_suscripciones  VALUES (NULL, '".$_GET['user']."', '".$_GET['channel']."')";
 
        $result=$conn->query($sql);
            if ($result!=1) {
                // oupsuss ssata of each row
                    echo "error";
            } else {
                        echo "success";
            }
         break;
     case 5:
    //listar canales donde estoy (params user) devuelve subscripciones
       $sql="SELECT * FROM tbl_suscripciones WHERE tbl_suscriptions_user == ".$_GET['user'];
 
        $result=$conn->query($sql);
            if ($result!=1) {
                // oupsuss ssata of each row
                    echo "error";
            } else {
            $rows= array();
            while( $row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
                        echo json_encode($rows);
            }
         break;
    case 6:
    //listar canales donde no estoy (params user)
       $sql="SELECT * FROM tbl_canal WHERE tbl_canal_name NOT IN (SELECT * FROM tbl_suscripciones WHERE tbl_suscriptions_user == ".$_GET['user']);
 
        $result=$conn->query($sql);
            if ($result!=1) {
                // oupsuss ssata of each row
                    echo "error";
            } else {
            $rows= array();
            while( $row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
                        echo json_encode($rows);
            }
         break;
    case 7:
    //Listar mensajes por canal (params channel)
       $sql="SELECT * FROM tbl_mensaje WHERE tbl_mensaje_channel == ".$_GET['channel'];
 
        $result=$conn->query($sql);
            if ($result!=1) {
                // oupsuss ssata of each row
                    echo "error";
            } else {
            $rows= array();
            while( $row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
                        echo json_encode($rows);
            }
         break;
    case 8:
    //Insertar mensaje (params channel & user & message)
       $sql="INSERT INTO tbl_mensaje  VALUES (NULL, '".$_GET['channel']."', '".$_GET['user']."','".$_GET['message']."')";
 
        $result=$conn->query($sql);
            if ($result!=1) {
                // oupsuss ssata of each row
                    echo "error";
            } else {
                        echo "success";
            }
         break;
    }
?>

