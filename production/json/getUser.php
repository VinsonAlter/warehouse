<?php

    require_once '../../function.php';

    if($_POST['username']) {

        $res = [];

        $username = $_POST['username'];

        $query = "SELECT * FROM [WMS-System].[dbo].[TB_User] 
                    
                  WHERE username = :username";

        $stmt = $conn->prepare($query, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);

        $stmt->bindParam(":username", $username, PDO::PARAM_STR);

        $stmt->execute();

        if($stmt->rowCount() > 0) {

            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                $server = explode(' ; ', $row['server']);

                $data = array(

                    'id' => $row['id'],

                    'nama' => $row['nama'],

                    'username' => $row['username'],

                    'server' => $server,

                    'aktif' => $row['aktif'],   

                );

            }

            $res['success'] = 1;

            $res['data'] = $data;

            $conn = null;

        } else {

            $res['success'] = 0;

            $res['message'] = "Gagal menampilkan data, mohon dicoba lagi";

        }

        echo json_encode($res);

    }

?>
