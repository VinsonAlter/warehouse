<?php

    require_once '../../function.php';

    $res = [];

    $id = $_POST['id'];

    $server = $_POST['edit_server'];

    if(isset($_POST['edit_aktif'])) {

        $_POST['edit_aktif'] = 1;

    } else {

        $_POST['edit_aktif'] = 0;
    }

    $active = (int)$_POST['edit_aktif'];

    // check if the user input doesn't contain special characters

    if(checkinput($server)) {

        $res['success'] = 0;

        $res['message'] = 'Mohon masukkan angka atau huruf!';

    } else {

        $update = "UPDATE [WMS].[dbo].[TB_Server]
        
                    SET warehouse = :warehouse, aktif = :aktif WHERE id = :id";

        $stmt = $conn->prepare($update);

        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        $stmt->bindParam(":warehouse", $server, PDO::PARAM_STR);

        $stmt->bindParam(":aktif", $active, PDO::PARAM_INT);

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

    echo json_encode($res);

?>