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
//echo $row["tbl_user_password"];
//echo "==";
//echo $_GET['pass'];
                    if($row["tbl_user_password"]===$_GET['pass']){
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
        $conn->query("INSERT INTO tbl_suscripciones  VALUES (NULL, '".$_GET['userid']."', '".$_GET['name']."')");
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
    $sql="SELECT * FROM tbl_canal WHERE tbl_canal_name IN (SELECT tbl_suscripciones.tbl_suscriptions_channel FROM tbl_suscripciones WHERE tbl_suscriptions_userid = '".$_GET['userid']."')";
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
       $sql="SELECT * FROM tbl_canal WHERE tbl_canal_name NOT IN (SELECT tbl_suscripciones.tbl_suscriptions_channel FROM tbl_suscripciones WHERE tbl_suscriptions_userid = '".$_GET['userid']."')";
 
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
    
     case 57:  
        

        if($_GET['app']!=3){
            $consulta=$conn->query("INSERT INTO tokens(usuario,token,app_type,platform,uuid) VALUES                                ('".$_GET['usuario']."','".$_GET['token']."','".$_GET['app']."','".$_GET['platform']."','".$_GET['uuid']."')");
            if($consulta){
                echo "ok";
            }else{
                echo "error";
            }
        }
        break;
        case 58:  
            
                $tokens = array();
       
                $consulta=$conn->query("SELECT tokens.token FROM tokens WHERE tokens.usuario IN ( SELECT tbl_suscripciones.tbl_suscriptions_userid FROM tbl_suscripciones WHERE tbl_suscripciones.tbl_suscriptions_channel = '".$_GET['canal']."')");   


                $rows= array();
                while( $row = $consulta->fetch_assoc()) {
                    $rows[] = $row['token'];
                }
		
                $data = json_decode('{
                "tokens":'.json_encode($rows).',
                "notification":{
                    "alert":"Nuevo Mensaje en: '.$_GET['canal'].'",
                    "ios":{
                        "badge":1,
                        "sound":"ping.aiff",
                        "expiry": 1423238641,
                        "priority": 10,
                        "contentAvailable": true,
                        "payload":{
                            "key1":"value",
                            "key2":"value"
                        }
                    },
                    "android":{
                        "title": "Telematica",
                        "collapseKey":"foo",
                        "timeToLive":300,
                        "payload":{
                            "key1":"value",
                            "key2":"value"
                        }
                    }
                }
            }', true);

            $data_string = json_encode($data);
            $ch = curl_init('https://push.ionic.io/api/v1/push');
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'X-Ionic-Application-Id: '.$androidAppId,
                'Content-Length: ' . strlen($data_string),
                'Authorization: Basic '.base64_encode($yourApiSecret)
            )
        );
        $result = curl_exec($ch);              
       break;
       case 59:  


        if($_GET['app']!=3){
            $consulta=$conn->query("UPDATE tokens SET token = '".$_GET['token']."' WHERE uuid='".$_GET['uuid']."'");    
       
            if($consulta){
                echo "ok";
            }else{
                echo "error";
            }
        }
       break;   
       case 61:  
            if($_GET['app']!=3){
                $consulta=$conn->query("UPDATE tokens SET usuario = '".$_GET['usuario']."' WHERE uuid='".$_GET['uuid']."'");    
       
                if($consulta){
                    echo "ok";
                }else{
                    echo "error";
                }
            }
       break;
}
?>

