<?php

    require_once '../../function.php';

    $res = [];

    $kode = $_POST['kode'];

    $name = $_POST['nama'];

    // set unchecked value as 0, and checked value as 1 (default check value)

    $aktif = isset($_POST['check']) ? $_POST['check'] : 0;

    $active = (int)$aktif;

    if(checkinput($kode) || checkinput($name)){

        $res['success'] = 0;

        $res['message'] = 'Mohon masukkan angka atau huruf!';

    } else {

        // check if PickerID already exists in database

        $check = "SELECT * FROM [WMS].[dbo].[TB_Picker] WHERE PickerID = :kode";

        $stmt = $conn->prepare($check, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);

            $stmt->bindParam(":kode", $kode, PDO::PARAM_STR);

            $stmt->execute();

            if($stmt->rowCount() > 0) {

                $res['success'] = 0;

                $res['message'] = 'Picker sudah terdaftar di database!';

            } else {

                $insert = "INSERT INTO [WMS].[dbo].[TB_Picker]
                            ([PickerID],[NamaPicker],[Aktif])
                            VALUES
                            (:kode, :nama, :aktif)";

                $stmt2 = $conn->prepare($insert, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);

                $stmt2->bindParam(":kode", $kode, PDO::PARAM_STR);
                        
                $stmt2->bindParam(":nama", $name, PDO::PARAM_STR);

                $stmt2->bindParam(":aktif", $active, PDO::PARAM_INT);

                $stmt2->execute();

                if($stmt2->rowCount() > 0) {

                    $res['success'] = 1;

                    $res['message'] = 'Data berhasil disimpan!';

                } else {

                    $res['success'] = 0;

                    $res['message'] = 'Data gagal disimpan, mohon coba lagi';

                }

            }

        $conn = null;

    }

    echo json_encode($res);

?>