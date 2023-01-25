<?php

    require_once '../../function.php';

    $res = [];

    $kode = $_POST['kode'];

    $name = $_POST['nama'];

    // set unchecked value as 0, and checked value as 1 (default check value)

    $aktif = isset($_POST['check']) ? $_POST['check'] : 0;

    $active = (int)$aktif;

    // prevent special characters inputs

    if(checkinput($kode) || checkinput($name)){

        $res['success'] = 0;

        $res['message'] = 'Mohon masukkan angka atau huruf!';

    } else {

        // check if DriverID already exists in database

        $check = "SELECT * FROM [WMS-System].[dbo].[TB_Driver] WHERE DriverID = :kode";

        $stmt = $conn->prepare($check, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);

            $stmt->bindParam(":kode", $kode, PDO::PARAM_STR);

            $stmt->execute();

            if($stmt->rowCount() > 0) {

                $res['success'] = 0;

                $res['message'] = 'Driver sudah terdaftar di database!';

            } else {

                $insert = "INSERT INTO [WMS-System].[dbo].[TB_Driver]
                            ([DriverID],[NamaDriver],[Aktif])
                            VALUES
                            (:kode, :nama, :aktif)";

                $stmt2 = $conn->prepare($insert, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);

                $stmt2->bindParam(":kode", $kode, PDO::PARAM_STR);
                        
                $stmt2->bindParam(":nama", $name, PDO::PARAM_STR);

                $stmt2->bindParam(":aktif", $active, PDO::PARAM_INT);

                $stmt2->execute();

                if($stmt2->rowCount() > 0) {

                    $res['success'] = 1;

                    $res['message'] = 'Data saved successfully!';

                } else {

                    $res['success'] = 0;

                    $res['message'] = 'Failed to save data, please try again later';

                }

            }

        $conn = null;

    }

    echo json_encode($res);

?>