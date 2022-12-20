<?php
    $dsn1_dummy = 'sqlsrv:server=192.168.100.100,1433;Database=SP-100011-MMKSI-dummy';

    $pdo_option = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

    try {

        $conn = new PDO($dsn1_dummy, 'sa', 'Brav02010IT', $pdo_option);

    } catch (PDOException $e) {

        echo $e->getMessage();

    }
?>

