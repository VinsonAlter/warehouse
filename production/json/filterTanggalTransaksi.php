<?php

    session_start();

    require_once '../../function.php';

    $user_data = $_SESSION['user_server'];

    $user_segmen = $_SESSION['segmen_user'];

    date_default_timezone_set('Asia/Jakarta');

    try {

        $awalTanggal = isset($_POST['awalTanggal']) ? $_POST['awalTanggal'] : date('01-m-Y');

        $akhirTanggal = isset($_POST['akhirTanggal']) ? $_POST['akhirTanggal'] : date('d-m-Y');

        foreach($user_data as $key => $value) {

          $filter[] = "SELECT P.[NoTransaksi], P.[Tgl], P.[Nama], P.[Owner] FROM $value P 

                        LEFT JOIN [WMS].[dbo].[TB_Delivery] D 
                        
                        ON P.NoTransaksi = D.NoTransaksi 

                        WHERE D.NoTransaksi IS NULL
          
                        AND [Tgl] BETWEEN 

                        '".date_to_str($awalTanggal)."' AND  

                        '".date_to_str($akhirTanggal)."' AND

                        P.[Segmen] IN ($user_segmen) AND

                        P.[Status] = '1' AND

                        isnull(P.[NoTransaksiOriginal], '') = ''";

          $filters = implode(" UNION ALL ", $filter);

        }

        $order_tgl = " ORDER BY [Tgl] DESC";

        $query = "SELECT * FROM($filters) temp" . $order_tgl;

        $stmt = $pdo->prepare($query, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);

		$stmt->execute();	

		if ($stmt->rowCount() > 0) {

			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                $data[] = array(
                    $row['NoTransaksi'],
                    $row['Tgl'],
                    $row['Nama'],
                    $row['Owner']
                );

            }

            for ($i=0;$i<count($data);$i++)
            {	
                $data[$i][1] = date('d-m-Y', strtotime($data[$i][1]));
                if (strtotime($data[$i][1]) != '') {
                    $data[$i][1] = date('d-m-Y', strtotime($data[$i][1]));
                } else {
                    $data[$i][1] = '';
                } 
            }

            $pdo = null;

        } else {

            $data = '';

        }

        $result = array(

            "data" => $data,

        );

    } catch (Exception $e) {

        $result = array(

            "data" => $data,
		    
            "error" => $e->getLine(),

        );
    }

    $pdo = null;

    echo json_encode($result);

?>