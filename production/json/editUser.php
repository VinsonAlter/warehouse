<?php

    require_once '../../function.php';

    $res = [];

    $nama = $_POST['edit_name'];

    $username = $_POST['edit_username'];

    $password = $_POST['edit_password'];

    $confirm = $_POST['edit_confirm'];

    $id = $_POST['id'];

    if(isset($_POST['edit_aktif'])) {

        $_POST['edit_aktif'] = 1;

    } else {

        $_POST['edit_aktif'] = 0;
    }

    if(!isset($_POST['server'])) {

        $server = '';

    } else {

        $server = $_POST['server'];

        $server = implode(' ; ', $_POST['server']);

    }

    // check if the user input doesn't contain special characters

    if(checkinput($nama) || checkinput($username) || checkinput($password) || checkinput($confirm)) {

        $res['success'] = 0;

        $res['message'] = 'Mohon masukkan angka atau huruf!';

    } else {

        if($password !== $confirm) {

            $res['success'] = 0;

            $res['message'] = 'Password & confirm password harus sama!';

        } else {

            $password = password_hash($password, PASSWORD_DEFAULT);

            $active = (int)$_POST['edit_aktif'];

            $update = "UPDATE [WMS-System].[dbo].[TB_User]
            
                        SET nama = :nama, username = :username,
                        
                            password = :password, server = '$server', aktif = :aktif 
                            
                            WHERE id = :id";

            $stmt = $conn->prepare($update);

            $stmt->bindParam(":nama", $nama, PDO::PARAM_STR);
            
            $stmt->bindParam(":username", $username, PDO::PARAM_STR);

            $stmt->bindParam(":password", $password, PDO::PARAM_STR);

            $stmt->bindParam(":aktif", $active, PDO::PARAM_INT);

            $stmt->bindParam(":id", $id, PDO::PARAM_INT);

            $stmt->execute();

            if($stmt->rowCount() > 0) {

                $res['success'] = 1;

                $res['message'] = 'Data berhasil diganti!';

            } else {

                $res['success'] = 0;

                $res['message'] = 'Data gagal diganti, mohon dicoba kembali!';

            }

            $conn = null;

        }

    }

    echo json_encode($res);

?>