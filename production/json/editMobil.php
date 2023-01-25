<?php

    require_once '../../function.php';

    $res = [];

    $plat = $_POST['edit_plat'];

    $jenis = $_POST['edit_jenis'];

    if(isset($_POST['edit_aktif'])) {

        $_POST['edit_aktif'] = 1;

    } else {

        $_POST['edit_aktif'] = 0;
    }

    $active = (int)$_POST['edit_aktif'];

    if(checkinput($jenis)) {

        $res['success'] = 0;

        $res['message'] = 'Mohon masukkan angka atau huruf!';

    } else {

        $update = "UPDATE [WMS-System].[dbo].[TB_Mobil]
        
                    SET Jenis = :jenis, Aktif = :aktif WHERE NoPlat = :plat";

        $stmt = $conn->prepare($update);

        $stmt->bindParam(":plat", $plat, PDO::PARAM_STR);

        $stmt->bindParam(":jenis", $jenis, PDO::PARAM_STR);

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