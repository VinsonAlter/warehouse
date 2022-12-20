<?php

    session_start();

    // require 'koneksi.php';

    require_once 'function.php';

    // empty the default value for nama
    
    $nama = '';
    if(!isset($_POST['login'])) {
      $msg = '';
    }

    if(isset($_POST['login'])) {
      $nama = $_POST['nama'];
      $password = $_POST['password'];
      // cegah login menggunakan karakter selain huruf atau angka
      if(checkinput($nama) || checkinput($password)) {
        $msg = "<div class='alert alert-danger' role='alert'>Mohon masukkan angka dan huruf!</div>";
      } else {
        $query = "SELECT * FROM [WMS-System].[dbo].[TB_User] WHERE username=:nama AND aktif = 1";
        $stmt = $conn->prepare($query, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]); 
          $stmt->bindParam(":nama", $nama, PDO::PARAM_STR);
          $stmt->execute();  
          $count = $stmt->rowCount();
          if($count > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
              $pass = $row['password'];
              $server = explode(' ; ', $row['server']);
              $username = $row['username'];
            }
            // $verify = password_verify($password, $row['password']);
            // old password encryption
            // $password = encrypt($_POST['password']);
            // old login, taken from SP-100011-MMKSI-dummy
            // $query = "SELECT * FROM [SP-100011-MMKSI-dummy].[dbo].[TB_User] WHERE UserID = :nama AND Password = :password";  
            // need PDO::CURSOR_SCROLL for row count
            if(password_verify($password, $pass)) {
              $_SESSION['user_login'] = $username;
              $pdo = new PDO($dsn1, 'sa', 'Brav02010IT', $pdo_option);
              foreach($server as $key => $value){
                $connect = "SELECT [Nama] FROM [".$value."].[dbo].[TB_Warehouse]";
                $stmt2 = $pdo->prepare($connect, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);
                $stmt2->execute();
                if ($stmt2->rowCount() > 0) {
                  while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
                    $warehouse[] = "[$value].[dbo].[TB_Penjualan_".$row2['Nama']."]";
                  } 
                }
              }
              $_SESSION['user_server'] = $warehouse;
              // var_dump($_SESSION['user_server']);
              header("location:production/index.php"); 
            } else {
              $msg = "<div class='alert alert-danger' role='alert'>Pastikan password yang diisi benar.</div>";
            }
          } else {
            $msg = "<div class='alert alert-danger' role='alert'>Username tidak terdaftar di database!</div>";
          }
        }
        $conn = null;
      }
              
              // var_dump($gudang);
              /* this is the hard coded version, above recomended to use the array ones
              if (in_array('SP-100011-MMKSI-dummy', $server)) {
                $connect = "SELECT [Nama] FROM [SP-100011-MMKSI-dummy].[dbo].[TB_Warehouse]";
                $stmt2 = $pdo->prepare($connect, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);
                $stmt2->execute();
                if ($stmt2->rowCount() > 0) {
                  while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
                    $warehouse[] = $row2['Nama'];
                  } 
                }
              }
              if (in_array('SP-TJM-MMKSI-dummy', $server)) {
                $connect2 = "SELECT [Nama] FROM [SP-TJM-MMKSI-dummy].[dbo].[TB_Warehouse]";
                $stmt3 = $pdo->prepare($connect2, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);
                $stmt3->execute();
                if ($stmt3->rowCount() > 0) {
                  while ($row3 = $stmt3->fetch(PDO::FETCH_ASSOC)){
                    $warehouse2[] = $row3['Nama'];
                  } 
                }
              }
              if (in_array('SP-TJM-KTB-dummy', $server)) {
                $connect3 = "SELECT [Nama] FROM [SP-TJM-KTB-dummy].[dbo].[TB_Warehouse]";
                $stmt4 = $pdo->prepare($connect2, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);
                $stmt4->execute();
                if ($stmt4->rowCount() > 0) {
                  while ($row4 = $stmt4->fetch(PDO::FETCH_ASSOC)){
                    $warehouse3[] = $row4['Nama'];
                  } 
                }
              }
              */
              // $_SESSION['user_server'] = array_merge($warehouse, $warehouse2, $warehouse3);
              // var_dump($_SESSION['user_server']);
              // header("location:production/index.php"); 
            
      
      
    
    
    /* old login function */
    //   $query = "SELECT * FROM [WMS-System].[dbo].[TB_User] WHERE username=:nama AND password=:password";
    //     $stmt = $conn->prepare($query, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]); 
    //     $stmt->bindParam(":nama", $nama, PDO::PARAM_STR);
    //     $stmt->bindParam(":password", $password, PDO::PARAM_STR);
    //     $stmt->execute();  
    //     $count = $stmt->rowCount();  
    //     if($count > 0)  
    //     { 
    //       $login = $stmt->fetch(PDO::FETCH_ASSOC);
    //       $_SESSION['user_login'] = $login['UserID'];
    //       $_SESSION['status'] == 'true';
    //       header("location:production/index.php"); 
    //     } else {
    //       $msg = "<div class='alert alert-danger' role='alert'>Pastikan Nama dan Password yang Anda isi benar.</div>";
    //     }
    //     $conn = null;
    // } 

    // if(isset($_SESSION['user_login'])) {
    //   header("location:production/index.php");  
    // }
    

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">

    <title>Warehouse CRM System</title>
  </head>
  <body>
  <?php if ($msg != '') echo $msg; ?>
    <section class="form-01-main">
      <div class="form-cover">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="form-sub-main">
              <div class="_main_head_as">
                <a href="#">
                  <img src="assets/images/logo-sardana.webp">
                </a>
              </div>
              <h2>Please login</h2>
              <form method="post">
              <div class="form-group">
                <input type="text" name="nama" value="<?=$nama?>" class="form-control _ge_de_ol" type="text" placeholder="Please enter Username" required autofocus aria-required="true">
              </div>
              <div class="form-group">                                              
                <input id="password" type="password" class="form-control" name="password" placeholder="Please enter password" required>
              </div>
              <div class="form-group">
                <div class="btn_uy">
                <button class="btn btn-lg btn-danger btn-block" name="login" type="submit">Login</button>
                </div>
              </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      </div>
    </section>
  </body>
</html>