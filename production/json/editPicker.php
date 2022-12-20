<?php

    require_once '../../function.php';

    $res = [];

    $id = $_POST['edit_kode'];

    $nama = $_POST['edit_nama'];

    if(isset($_POST['edit_aktif'])) {

        $_POST['edit_aktif'] = 1;

    } else {

        $_POST['edit_aktif'] = 0;
    }

    $active = (int)$_POST['edit_aktif'];

    if(checkinput($nama)) {

        $res['success'] = 0;

        $res['message'] = 'Mohon masukkan angka atau huruf!';

    } else {

        $update = "UPDATE [WMS-System].[dbo].[TB_Picker]
        
                    SET Nama = :nama, Aktif = :aktif WHERE PickerID = :id";

        $stmt = $conn->prepare($update);

        $stmt->bindParam(":id", $id, PDO::PARAM_STR);

        $stmt->bindParam(":nama", $nama, PDO::PARAM_STR);

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