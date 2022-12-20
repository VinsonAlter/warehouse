<?php

    session_start();

    require_once '../../function.php';

    $user_data = $_SESSION['user_server'];

    date_default_timezone_set('Asia/Jakarta');

    try {

        // $awalTanggal = $_POST['awalTanggal'];

        // $akhirTanggal = $_POST['akhirTanggal'];

        // today date, comment this out since with this date, the query not gonna's work

        // $awalTanggal = isset($_POST['awalTanggal']) ? $_POST['awalTanggal'] : date('01-m-Y');

        // $akhirTanggal = isset($_POST['akhirTanggal']) ? $_POST['akhirTanggal'] : date('d-m-Y');

        $awalTanggal = isset($_POST['awalTanggal']) ? $_POST['awalTanggal'] : date('01-m-Y');

        $akhirTanggal = isset($_POST['akhirTanggal']) ? $_POST['akhirTanggal'] : date('d-m-Y');

        // if (isset($_SESSION['FilterChecklistDateFrom'])) $awalTanggal = $_SESSION['FilterChecklistDateFrom'];

  	    // if (isset($_SESSION['FilterChecklistDateTo'])) $akhirTanggal = $_SESSION['FilterChecklistDateTo'];

        foreach($user_data as $key => $value) {

          $filter[] = "SELECT P.[NoTransaksi] FROM $value P 

                        LEFT JOIN [WMS-System].[dbo].[TB_Delivery] D 
                        
                        ON P.NoTransaksi = D.NoTransaksi 

                        WHERE D.NoTransaksi IS NULL
          
                        AND [Tgl] BETWEEN 

                        '".date_to_str($awalTanggal)."' AND  

                        '".date_to_str($akhirTanggal)."' AND

                        P.[Segmen] IN ('AS', 'CO') AND

                        P.[Status] = '1' AND 

                        P.[NoTransaksiOriginal] IS NULL
                        
                        ";

          $filters = implode(" UNION ALL ", $filter);

        }

        $stmt = $pdo->prepare($filters, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);

		$stmt->execute();	

		if ($stmt->rowCount() > 0) {

			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

				$transaksi[] = $row['NoTransaksi'];

            }
        }

        $result = array(

            "data" => $transaksi

        );

    } catch (Exception $e) {

        $result = array(

            "data" => $transaksi,
		    
            "error" => $e->getMessage(),

        );
    }

    echo json_encode($result);

?>