<?php
include 'connection.php';
header("Access-Control-Allow-Origin: *");


 switch ($_GET['op']) {   
    //direccion urlBase = http://10.131.137.200/proyecto1controller/dataAccess.php?op=
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
    //nuevo usuario params user & pass
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
    //crear nuevo canal sparams name, userid)
       $sql="INSERT INTO tbl_canal  VALUES (NULL, '".$_GET['name']."', '".$_GET['userid']."')";
        query("INSERT INTO tbl_suscripciones  VALUES (NULL, '".$_GET['userid']."', '".$_GET['name']."')");
        $result=$conn->query($sql);
            if ($result!=1) {
                // oupsuss ssata of each row
                    echo "error";
	
            } else {
                        echo "success";
            }
         break;
 
     case 4:
    //registrar usuario en canal (params userid & channel)
       $sql="INSERT INTO tbl_suscripciones  VALUES (NULL, '".$_GET['userid']."', '".$_GET['channel']."')";
 
        $result=$conn->query($sql);
            if ($result!=1) {
                // oupsuss ssata of each row
                    echo "error";
            } else {
                        echo "success";
            }
         break;
     case 5:
    //listar canales donde estoy (params userid) devuelve subscripciones
    $sql="SELECT * FROM tbl_canal WHERE tbl_canal_name IN (SELECT tbl_suscripciones.tbl_suscriptions_channel FROM tbl_suscripciones WHERE tbl_suscriptions_userid = '".$_GET['userid']."'')";
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
    //listar canales donde no estoy (params userid)
       $sql="SELECT * FROM tbl_canal WHERE tbl_canal_name NOT IN (SELECT tbl_suscripciones.tbl_suscriptions_channel FROM tbl_suscripciones WHERE tbl_suscriptions_userid = '".$_GET['userid']."'')";
 
        $result=$conn->query($sql);
            if ($result!=1) {
                // oupsuss ssata of each row
                   // echo "error";
			echo $sql;
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
       $sql="SELECT * FROM tbl_mensaje WHERE tbl_mensaje_channel = '".$_GET['channel']."'";
 
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
    //Insertar mensaje (params channel & userid & message)
       $sql="INSERT INTO tbl_mensaje  VALUES (NULL, '".$_GET['channel']."', '".$_GET['userid']."','".$_GET['message']."')";
 
        $result=$conn->query($sql);
            if ($result!=1) {
                // oupsuss ssata of each row
                    echo "error";
            } else {
                        echo "success";
            }
         break;

    case 9:
    //Listar todos los id de usuarios subscritos a un canal (params channel)
       $sql="SELECT tbl_suscriptions_userid FROM tbl_suscripciones WHERE tbl_suscriptions_channel ='".$_GET['channel']."'";
 
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
    case 10:
    //recibir el user id dado el username (params username)
    $sql="SELECT tbl_user_id FROM tbl_user WHERE tbl_user_username ='".$_GET['username']."'";
 
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
    }
?>

