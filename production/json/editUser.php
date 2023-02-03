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
    // check if the user input doesn't contain special characters
    if(checkinput($nama) || checkinput($username)) {
        $res['success'] = 0;
        $res['message'] = 'Mohon masukkan angka atau huruf!';
    } else {
        if(!isset($_POST['server']) && !isset($_POST['segmen'])) {
            $res['success'] = 0;
            $res['message'] = 'Checkbox Server & Segmen harus dicentang setidaknya satu!';
        } else {
            $server = implode(' ; ', $_POST['server']);
            $segmen = implode(' ; ', $_POST['segmen']);
            $otoritas = implode(' ; ', $_POST['otoritas']);
            if($_POST['edit_password'] != '' && $_POST['edit_confirm'] != '') {
                if($password !== $confirm) {
                    $res['success'] = 0;
                    $res['message'] = 'Password & confirm password harus sama!';
                } else {
                    $password = password_hash($password, PASSWORD_DEFAULT);
                    $active = (int)$_POST['edit_aktif'];
                    $update = "UPDATE [WMS].[dbo].[TB_User]
                                SET nama = :nama, username = :username,
                                password = :password, server = '$server', segmen = '$segmen', otoritas = '$otoritas', aktif = :aktif  
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
                }
            } else {
                $active = (int)$_POST['edit_aktif'];
                $update = "UPDATE [WMS].[dbo].[TB_User]
                            SET nama = :nama, username = :username,
                            server = '$server', segmen = '$segmen', otoritas = '$otoritas', aktif = :aktif  
                            WHERE id = :id";
                $stmt = $conn->prepare($update);
                $stmt->bindParam(":nama", $nama, PDO::PARAM_STR);
                $stmt->bindParam(":username", $username, PDO::PARAM_STR);
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
            }}
        } 
    $conn = null;
    echo json_encode($res);
?>