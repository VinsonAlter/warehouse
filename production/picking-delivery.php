<?php
    session_start();
    // require_once '../koneksi.php';
    require_once '../function.php';
    date_default_timezone_set('Asia/Jakarta');
    // cek apakah user sudah login, apabila belum login arahkan user ke laman login
    if(!isset($_SESSION['user_login'])) {
      header("location:../login.php");  
    }
    $nama = $_SESSION['user_login'];
    $tglTransaksi = date('d-m-Y');
    $tglTerima = date('d-m-Y');
    $state = '';
    if(isset($_REQUEST['filter_tgl'])) {
      $state = $_REQUEST['enable_date'];
      if($_REQUEST['enable_date'] == 'transaksi_on') {
        $status = 'transaksi_on';
        $_SESSION['StatusFilter'] = $status;
        $_SESSION['FilterTglTransaksi'] = $_POST['tglTransaksi'];
        $_SESSION['FilterTglTerima'] = date('d-m-Y');
      } else  {
        $status = 'terima_on';
        $_SESSION['StatusFilter'] = $status;
        $_SESSION['FilterTglTerima'] = $_POST['tglTerima'];
        $_SESSION['FilterTglTransaksi'] = date('d-m-Y');
      }
    }

    if(isset($_SESSION['FilterTglTransaksi'])) $tglTransaksi = $_SESSION['FilterTglTransaksi'];

    if(isset($_SESSION['FilterTglTerima'])) $tglTerima = $_SESSION['FilterTglTerima'];
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="author" content="Vinson">
    <title>PT. Sardana IndahBerlian Motor</title>
    <!-- Favicon icon -->
    <link
      rel="icon"
      type="image/png"
      sizes="16x16"
      href="assets/images/sardana.png"
    />
    <!-- Custom CSS -->
    <link
      rel="stylesheet"
      type="text/css"
      href="assets/extra-libs/multicheck/multicheck.css"/>
    <link
      href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css"
      rel="stylesheet"/>
    <link href="css/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <link href="css/datatables.css" rel="stylesheet"/>
    <!-- Bootstrap Datepicker CSS -->
    <link rel="stylesheet" type="text/css" href="assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css"/>
    <!-- Loading CSS -->
    <link href="css/loading.css" rel="stylesheet"/>
    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">
    <style>

      /* body {
        overflow:hidden;
      } */
      
      .bg-belum-diterima { 
        background-color: #fcb1ac !important;
      }

      .bg-diterima {
        background-color: #ff9933 !important;
      }

      .highlight {
        background-color: yellowgreen !important;
      }

      .nav-img {
        margin-right: 10px;
      }

      .pro-pic:hover{
        color: whitesmoke !important;
      }

      .profile-sidebar {
        opacity: 1 !important;
      }

      .sidebar-link img {
        width: 45px;
        margin-right: 15px;
      }

      .page-logo {
        font-family: 'Montserrat', sans-serif;
        font-size: 2.5rem;
        color: #ed0000;
      }

      .btn {
        color: #000;
      }

      .btn:hover {
        color: #fff;
      }

      /* adding required labels */
      
      .required::before {
        content: ' * ';
        color: red;
        margin-right: 3px;
      }

      div.dataTables_wrapper div.dataTables_processing {
				height: 100%;
				width: 100%;
				position: fixed;
				top: 0;
				left: 0;
				margin-top:1px;
				margin-left:1px;
				z-index: 99999;
				background-color: gray;
				-moz-opacity: 0.50;
				opacity: 0.50;
			}

			div.dataTables_wrapper div.dataTables_processing .loader{
				position: absolute;
				top: 50%;
				left: 50%;
			}


    </style>

  </head>

  <body>
    <div class='loader'></div>
    <div class="preloader">
      <div class="lds-ripple">
        <div class="lds-pos"></div>
        <div class="lds-pos"></div>
      </div>
    </div>

    <div
      id="main-wrapper"
      data-layout="vertical"
      data-navbarbg="skin5"
      data-sidebartype="full"
      data-sidebar-position="absolute"
      data-header-position="absolute"
      data-boxed-layout="full"
    >
      <?php require_once 'header-navbar.php';?>
      <aside class="left-sidebar" data-sidebarbg="skin5">
        <div class="scroll-sidebar">
          <?php require_once 'sidebar.php'; ?>
          
        </div>
      </aside>
      <div class="page-wrapper">
        <div class="page-breadcrumb">
          <div class="row">
            <div class="col-10 d-flex no-block align-items-center">
              <h4 class="page-title">Picking & Delivery</h4>
              <div class="ms-auto text-end d-flex">
                <select
                  class="cp select2 form-select shadow-none"
                    style="width: 50%; height:36px; margin-right:12px"
                    id="select_picker" name="picker">
                </select>
                <button class="btn btn-cyan" type="button" id="update_pick" name="update_terima"
                  style="width:180px;">Update Picking</button>
              </div>
            </div>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <form method="post" action="" role="form">
                    <div class="col-md-8">
                      <div class="ml-15em form-group">
                        <div class="mb-2">
                          <div class="d-sm-inline-block d-md-flex mb-3">
                            <label class="mb-3 mb-md-0 mr-half centered d-md-flex">Filter Tgl Transaksi</label>
                            <input type="radio" class="cp mr-8" id="filter_transaksi" name="enable_date" value="transaksi_on" onclick="enable_transaksi()">
                            <input type="text" class="col-md-2 col-4 mydatepicker"
                              name="tglTransaksi" id="tgl_transaksi" value="<?=$tglTransaksi?>" autocomplete="off">
                            <button class="px-2 btn btn-success btn-sm text-white ml-half"
                              type="submit" name="filter_tgl" id="btn_filter">
                              Filter
                            </button>
                          </div>
                          <div class="d-sm-inline-block d-md-flex">
                            <label class="mb-3 mb-md-0 mr-16em centered d-md-flex">Filter Tgl Terima</label>
                            <input type="radio" class="cp mr-8" id="filter_terima" name="enable_date" value="transaksi_off" onclick="enable_terima()">
                            <input type="text" class="col-md-2 col-4 mydatepicker"
                              name="tglTerima"id="tgl_terima"  value="<?=$tglTerima?>" autocomplete="off">
                            <!-- <button class="px-2 btn btn-success btn-sm text-white ml-half"
                              type="submit" name="filter_tgl_terima" id="btn_terima">
                              Filter
                            </button> -->
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="table-responsive">
                  <table id="table_picking" class="cp table table-bordered table-condensed display compact">
                    <thead>
                      <tr>
                        <th><input type="checkbox" id="select_all" class="cp"></th>
                        <th>No Transaksi</th>
                        <th>Tgl Transaksi</th>
                        <th>Customer</th>
                        <th>Status</th>
                        <th>Tanggal Terima</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
    
      </div>
    <script src="assets/libs/jquery/dist/jquery.min.js"></script>
    
    <!-- Bootstrap tether Core JavaScript -->
    <script src="assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- This Bundle includes working Modals Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    
    <script src="assets/extra-libs/sparkline/sparkline.js"></script>

    <!--Wave Effects -->
    <script src="js/waves.js"></script>
    
    <!--Menu sidebar -->
    <script src="js/sidebarmenu.js"></script>

    <!--Custom JavaScript -->
    <script src="js/custom.min.js"></script>

    <!-- this page js -->
    <script src="assets/extra-libs/multicheck/datatable-checkbox-init.js"></script>

    <script src="assets/extra-libs/multicheck/jquery.multicheck.js"></script>

    <script src="assets/extra-libs/DataTables/datatables.min.js"></script>

     <!-- Datepicker JS -->
     <script src="assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

    <script>

      let checkValues = [];

      

      var state = '<?php echo $state ?>';

      function selectPicker() {
          $.ajax({
            type: "post",
            url: "json/search_picker.php",
            success: result => {
              const res = $.parseJSON(result);
              if (res.success == 1) {
                if($('#select_picker').children().length == 0) {
                  for (i = 0; i < res.data.length; ++i) {
                    $('<option>',
                    {
                      html: (res.data[i]).concat(' (' + res.id_data[i] + ')'), 
                      value: res.id_data[i],
                    }).appendTo('#select_picker');
                  }
                }   
              }
            },
            error: err => {
              console.error(err.statusText);
            }
          })
        }

      $(document).ready(() => {
        
        selectPicker();

        /* hide the loader first */
        $('.loader').hide();

        /*datepicker*/
        $(".mydatepicker").datepicker({
          format: 'dd-mm-yyyy',
          /* disable sunday in datepicker */
          daysOfWeekDisabled: "0",
          autoclose: true,
          todayHighlight: true
        });
        
        if(state == '' || state == 'transaksi_on') {
          $('#filter_transaksi').prop('checked', true);
          $('#tgl_transaksi').prop('disabled', false);
        } else {
          $('#filter_terima').prop('checked', true);
        }

        if(!$('#filter_transaksi').is(':checked')) {
            $('#tgl_transaksi').prop('disabled', true);
          } else {
            $('#tgl_transaksi').prop('disabled', false);
        }

        if(!$('#filter_terima').is(':checked')) {
            $('#tgl_terima').prop('disabled', true);
          } else {
            $('#tgl_terima').prop('disabled', false);
        }

        

        // fill datatables 
        var tablePicking = $('#table_picking').DataTable({
          "processing": true,
          "serverSide": true,
          "deferRender": true,
          "stateSave": true,
          "stateDuration": -1,
          "pageLength": 25,
          "ajax": {
            url: "json/getDataDelivery.php"
          },
          "language": {
            "processing": '<div class="loader"></div>',
          },
          "order": [[1, "asc"]],
          "columnDefs": [
            { orderable: false, targets: [0, 1]},
            { targets: 4,
              render: function(data){
                if(data == 1)
                  return '<b>Diterima</b>'
                  else
                  return '<b>Belum Diterima</b>'
              }
            },
            { className: 'dt-center', targets: [4]}
          ],
          "rowCallback": function(row, data, index) {
            const cellValue = data[4];
            if(cellValue == 1) {
              $('td:eq(4)', row).addClass("bg-diterima");
            } else {
              $('td:eq(4)', row).addClass("bg-belum-diterima");
            }
          },
          "drawCallback": function( settings ) {
            checkValues = [];
            $("input[type=checkbox]").prop('checked', false);
            $("input[type=checkbox]").closest('tr').removeClass('highlight');
            // work around fixedColumns highlight
            $("input[type=checkbox]").closest('tr .dtfc-fixed-left').removeClass('highlight');
            $("input[type=checkbox]").closest('tr .dtfc-fixed-left').nextUntil('tr .dtfc-fixed-left:nth-child(5)').removeClass('highlight');
          } 
        });

        $('#update_pick').click((e) => {
            e.preventDefault();
            // let checkValues = []; 
            // $('#checkbox_val:checked').map(function(){
            //   // console.log($(this).val());
            //   // return $(this).val();
            //   checkValues.push($(this).val());
            //   // $(this).prop('checked', false);
            // })
            
            const picker = $('#select_picker').val();
            // alert(Picker);
            // alert(checkValues);
            const CheckValues = checkValues.join(" ; ");
            $.ajax({
              type: "post",
              url: 'json/insertTransaksiTerima.php',
              data: {batch : CheckValues, picker: picker},
              success: result => {
                checkValues = [];
                const res = $.parseJSON(result);
                if(res.success == 1) {
                  e.preventDefault();
                  $('input[type=checkbox]').prop('checked',false);
                  $('#table_picking').DataTable().ajax.reload();
                  // window.location.reload();
                  alert(res.message);
                  // $('#checkbox_val').prop('checked', false);
                } else {
                  alert(res.message);
                }
              } ,
              error: err => {
                console.error(err.statusText);
              }
            })
          })

        tablePicking.on('draw.dt', () => {
          $('tr').find("input[type='checkbox']").on('click', function() {
            if ($(this).prop('checked') === true) {
              $(this).closest('tr').addClass('highlight');
              // work around fixedColumns highlight
              $(this).closest('tr .dtfc-fixed-left').addClass('highlight');
              $(this).closest('tr .dtfc-fixed-left').nextUntil('tr .dtfc-fixed-left:nth-child(5)').addClass('highlight');
              checkValues.push($(this).val());
              console.log(checkValues);
            } else {
              $(this).closest('tr').removeClass('highlight');
              // work around fixedColumns highlight
              $(this).closest('tr .dtfc-fixed-left').removeClass('highlight');
              $(this).closest('tr .dtfc-fixed-left').nextUntil('tr .dtfc-fixed-left:nth-child(5)').removeClass('highlight');	  
              checkValues.pop($(this).val());
              console.log(checkValues);
            }
          });

          /* initiate select all checkboxes highlight */ 

				  $('tr').find('#select_all').on('click', function() {
					  $("input[type='checkbox']").prop('checked', $(this).prop('checked'));
					  if ($(this).prop('checked') === true) {
						  $("input[type='checkbox']").closest('tr').addClass('highlight');
              // work around fixedColumns highlight
              $("input[type='checkbox']").closest('tr .dtfc-fixed-left').addClass('highlight');
              $("input[type='checkbox']").closest('tr .dtfc-fixed-left').nextUntil('tr .dtfc-fixed-left:nth-child(5)').addClass('highlight');
              $($('td #checkbox_val').prop('checked', true)).map(function(){
                checkValues.push($(this).val());
                // checkValues.shift($(this).val());
              })
              checkValues.shift($(this).val());
              console.log(checkValues);
            } else {
              $("input[type='checkbox']").closest('tr').removeClass('highlight');
              // work around fixedColumns highlight
              $("input[type='checkbox']").closest('tr .dtfc-fixed-left').removeClass('highlight');
              $("input[type='checkbox']").closest('tr .dtfc-fixed-left').nextUntil('tr .dtfc-fixed-left:nth-child(5)').removeClass('highlight');
              $($('td #checkbox_val').prop('checked', false)).map(function(){
                checkValues = [];
              })
              console.log(checkValues);
            }
            // if ($(this).is( ":checked" )) {
            //     tablePicking.rows(  ).select();        
            // } else {
            //     tablePicking.rows(  ).deselect(); 
            // }
				  });

          
        })

        // tablePicking.on('draw.dt', () => {
        //   const PageInfo = $('#table_picking').DataTable().page.info();
			  //   tablePicking.column(0, { page: 'current' }).nodes().each((cell, i) => {
				//     cell.innerHTML = i + 1 + PageInfo.start
			  //   })
        // }) 
      })

      

      function enable_transaksi() {
        $('#tgl_transaksi').prop('disabled', false);
        $('#tgl_terima').prop('disabled', true);     
      }

      function enable_terima() {
        $('#tgl_transaksi').prop('disabled', true);
        $('#tgl_terima').prop('disabled', false);
      }

    </script>
  </body>
</html>
