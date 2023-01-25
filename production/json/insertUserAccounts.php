<?php 
    require_once '../../function.php';
    $res = [];
    $name = $_POST['name'];
    $username = strtolower(erasewhitespace($_POST['userName']));
    $password = $_POST['password'];
    $confirm = $_POST['conf_pass'];
    $aktif = isset($_POST['check']) ? $_POST['check'] : 0;
    $active = (int)$aktif;
    // prevent special characters inputs
    if(checkinput($name) || checkinput($username) || checkinput($password) || checkinput($confirm)) {
        $res['success'] = 0;
        $res['message'] = 'Mohon masukkan angka atau huruf';
    } else {
        // check if password and confirm password are the same
        if($password !== $confirm) {
            $res['success'] = 0;
            $res['message'] = 'Password & confirm password harus sama!';
        } else {
            $check = "SELECT * FROM [WMS-System].[dbo].[TB_User] WHERE username = :username";
            $stmt = $conn->prepare($check, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
            if($stmt->rowCount() > 0) {
                $res['success'] = 0;
                $res['message'] = 'Username sudah terdaftar di database!';
            } else {
                // encrypt the password
                $password = password_hash($password, PASSWORD_DEFAULT);
                if(isset($_POST['server']) && isset($_POST['segmen'])) {
                    $server = $_POST['server'];
                    $server = implode(' ; ', $_POST['server']);
                    $segmen = $_POST['segmen'];
                    $segmen = implode(' ; ', $_POST['segmen']);
                    $otoritas = $_POST['otoritas'];
                    $otoritas = implode(' ; ', $_POST['otoritas']);
                    $insert = "INSERT INTO [WMS-System].[dbo].[TB_User] ([nama], [username], [password], [server], [segmen], [otoritas], [aktif])       
                                VALUES (:name, :user, :password, '$server', '$segmen', '$otoritas', :aktif)";
                    $stmt2 = $conn->prepare($insert, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);
                    $stmt2->bindParam(':name', $name, PDO::PARAM_STR);
                    $stmt2->bindParam(':user', $username, PDO::PARAM_STR);
                    $stmt2->bindParam(':password', $password, PDO::PARAM_STR);
                    $stmt2->bindParam(':aktif', $active, PDO::PARAM_INT);
                    // $stmt2->bindParam(':server', $server, PDO::PARAM_STR);
                    $stmt2->execute();
                    if($stmt2->rowCount() > 0) {
                        $res['success'] = 1;
                        $res['message'] = 'User baru berhasil didaftar!';
                    } else {
                        $res['success'] = 0;
                        $res['message'] = 'User gagal didaftar, mohon periksa koneksi Anda!';
                    }
                } else {
                    $res['success'] = 0;
                    $res['message'] = 'Checkbox Server, Segmen dan Otoritas harus dicentang setidaknya satu!';
                }
            } 
            $conn = null;
        }
    }
    echo json_encode($res);
?>