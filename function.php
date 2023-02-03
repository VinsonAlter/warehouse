<?php

    // password decryption for SP-100011-MMKSI-dummy TB_User table
    function encrypt($pass){
        for ($i=0; $i < strlen($pass); $i++)
        {
            if (ord(substr($pass, $i, 1)) < 128)
		        $strTempChar = ord(substr($pass, $i, 1)) + 128;
	        else
		        $strTempChar = ord(substr($pass, $i, 1)) - 128;
	        $pass = substr_replace($pass, chr($strTempChar), $i, 1);
        }
        return utf8_encode($pass);
    }

    $pdo_option = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

    $dsn = 'sqlsrv:server=192.168.100.100,1433;Database=WMS';
    try {
        $conn = new PDO($dsn, 'sa', 'Brav02010IT', $pdo_option);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    function query($query) {
        global $conn;
        $stmt = $conn->prepare($query, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);
        $stmt->execute();
        $rows = [];
        if($stmt->rowCount() > 0) {
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
               $rows[] = $row;
            }
            return $rows;
        }
    }

    $dsn1 = 'sqlsrv:server=192.168.100.100,1433;';
    try {
        $pdo = new PDO($dsn1, 'sa', 'Brav02010IT', $pdo_option);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    function queries($query) {
        global $pdo;
        $stmt = $pdo->prepare($query, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);
        $stmt->execute();
        $rows = [];
        if($stmt->rowCount() > 0) {
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
               $rows[] = $row;
            }
            return $rows;
        }
    }
    
    // replace spaces, caps low and replace specialchars
    function clean($string) {
        $string = str_replace(array(':', '-', '/', '*'), '', $string);
        $string = strtolower($string);
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
    }

    // prevent invalid characters or special chars 
    function checkinput($string) {
        $string = preg_match_all("/[^A-Za-z0-9- ]/", $string);
        return $string;
    }

    // erase whitespace from character in strings

    function erasewhitespace($string) {
        $string = str_replace(" ", "", $string);
        return $string;
    }

    // convert date d-m-Y to string Y-m-d
    function date_to_str($date)
	{
		if (($date == '') || (strlen($date) <> 10))
			return false;
		$reform = substr($date,6,4) . '-' . substr($date,3,2) . '-' .substr($date,0,2);
		return $reform;
	}

    // convert date d-m-Y H:i:s to string Y-m-d H:i:s
    function date_hour_to_str($date)
    {
        if (($date == '') || (strlen($date) <> 19))
			return false;
        $reform = substr($date,6,4) . '-' . substr($date,3,2) . '-' .substr($date,0,2) 
                    . ' ' . substr($date, 11,2) . ':' . substr($date, 14, 2) . ':' . substr($date, 17, 2);
        return $reform;
    }

    // convert date H:i:s to string H:i:s
    function hour_to_str($date)
    {
        if (($date == ''))
            return false;
        $reform = substr($date,0,2) . ':' .substr($date,3,2). ':' .substr($date,6,2);
        return $reform;
    }

    // convert into sql datetime format
    function sqlserver_datetime_format($datetime, $divider='-', $separator='-')
    {
        if (empty($datetime)) return '';
        else
        {
        $result = substr($datetime, 0, 10);
        $datetime = substr($datetime, 10);
        $result = explode($separator, $result);
        $result = $result[2] . $divider . $result[1] . $divider . $result[0] . $datetime;
        return $result;
        }
    }	

?>