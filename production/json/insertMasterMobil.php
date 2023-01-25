<?php

    require_once '../../function.php';

    $res = [];

    $plat = strtoupper($_POST['plat']);

    $jenis = $_POST['jenis'];

    // set unchecked value as 0, and checked value as 1 (default check value)

    $aktif = isset($_POST['check']) ? $_POST['check'] : 0;

    $active = (int)$aktif;

    // prevent special characters inputs

    if(checkinput($plat) || checkinput($jenis)){

        $res['success'] = 0;

        $res['message'] = 'Mohon masukkan angka atau huruf!';

    } else {
        
        // check if no plat already exist in database

        $check = "SELECT * FROM [WMS-System].[dbo].[TB_Mobil] WHERE NoPlat = :plat";

        $stmt = $conn->prepare($check, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);

            $stmt->bindParam(":plat", $plat, PDO::PARAM_STR);

            $stmt->execute();

            if($stmt->rowCount() > 0) {

                $res['success'] = 0;

                $res['message'] = 'Plat mobil sudah terdaftar di database!';

            } else {
        
                $insert = "INSERT INTO [WMS-System].[dbo].[TB_Mobil]
                            ([NoPlat],[Jenis],[Aktif])
                            VALUES
                            (:plat, :jenis, :aktif)";

                $stmt2 = $conn->prepare($insert, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);

                $stmt2->bindParam(":plat", $plat, PDO::PARAM_STR);
                        
                $stmt2->bindParam(":jenis", $jenis, PDO::PARAM_STR);

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