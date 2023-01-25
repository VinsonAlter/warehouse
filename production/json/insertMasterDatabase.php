<?php

    require_once '../../function.php';

    $res = [];

    $database = $_POST['database'];

    // set unchecked value as 0, and checked value as 1 (default check value)

    $aktif = isset($_POST['check']) ? $_POST['check'] : 0;

    $active = (int)$aktif;

    // prevent special characters inputs

    if(checkinput($database)) {

        $res['success'] = 0;

        $res['message'] = 'Database hanya menerima inputan berupa huruf, angka, maupun garis seperti -';

    } else {

        // check if DriverID already exists in database

        $check = "SELECT * FROM [WMS-System].[dbo].[TB_Server] WHERE warehouse = :database";

        $stmt = $conn->prepare($check, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);

            $stmt->bindParam(":database", $database, PDO::PARAM_STR);

            $stmt->execute();

            if($stmt->rowCount() > 0) {

                $res['success'] = 0;

                $res['message'] = 'Database sudah terdaftar!';

            } else {

                $insert = "INSERT INTO [WMS-System].[dbo].[TB_Server]
                            ([warehouse],[aktif])
                            VALUES
                            (:database, :aktif)";

                $stmt2 = $conn->prepare($insert, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);

                $stmt2->bindParam(":database", $database, PDO::PARAM_STR);
                    
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