<?php
date_default_timezone_set('Asia/Manila');
session_start();

if(!isset($_SESSION["isAdmin"])){
  header("Location: auth-login-basic.php");
}


include '../functions/config.php';
$expiresAt = new \DateTime('tomorrow');
$user = $auth->getUser($_SESSION['verified_user_id']);
$photoURL=$storage->getBucket()->object($user->photoUrl)->signedUrl($expiresAt);

if(isset($_GET["delete"])&&$_SESSION["isAdmin"]==2){
  $path=$_GET["d"]."/".$_GET["q"]."/".$_GET["file"];
$database->getReference('Files/'.$path)->remove();
header("Location: public.php");
}


 ?>
<!DOCTYPE html>
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>My Files - eFileCabinet</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/img/logos/cdrrmologo.png" />


    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <link rel="stylesheet" href="../assets/vendor/libs/apex-charts/apex-charts.css" />
    <style media="screen">
      th,td{
        text-align: center;
      }
      td>a:hover{
        text-decoration: underline;
      }
      .center{
        display: block;
        margin-left: auto;
        margin-right: auto;
      }
      th{
        cursor: pointer;
      }
    </style>
    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="../assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../assets/js/config.js"></script>
  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
            <a href="index.php" class="app-brand-link">
              <span class="app-brand-logo demo">
                <img src="../assets/img/logos/cdrrmologo.png" alt="" height="50px" width="50px">
              </span>
              <span class="app-brand-text menu-text fw-bolder ms-2">eFileCabinet</span>
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
              <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
          </div>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">
            <!-- Home -->
            <li class="menu-item active">
              <a href="index.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Home</div>
              </a>
            </li>

            <li class="menu-header small text-uppercase">
              <span class="menu-header-text">Actions</span>
            </li>
            <?php
            if ($_SESSION["isAdmin"]==2) {
              echo '<li class="menu-item">
                        <a data-bs-toggle="modal"
                        data-bs-target="#modalCenter" class="menu-link" style="cursor: pointer;">
                          <i class="menu-icon tf-icons bx bx-folder-plus"></i>
                          <div data-i18n="Analytics">Upload</div>
                        </a>
                      </li>
                      <!--li class="menu-item">
                        <a href="myuploads.php" class="menu-link">
                          <i class="menu-icon tf-icons bx bxs-folder-open"></i>
                          <div data-i18n="Analytics">My Files</div>
                        </a>
                      </li-->
                      <li class="menu-item">
                          <a href="file.php" class="menu-link">
                            <i class="menu-icon tf-icons bx bxs-hand"></i>
                            <div data-i18n="Analytics">For My Action</div>
                          </a>
                        </li>
                      ';
                    }
    if ($_SESSION["isAdmin"]!=1) {
                      echo '<li class="menu-item active">
                        <a href="public.php" class="menu-link">
                          <i class="menu-icon tf-icons bx bxs-folder"></i>
                          <div data-i18n="Analytics">Files Cabinet</div>
                        </a>
                      </li>';
}
             ?>




                <?php
                if ($_SESSION["isAdmin"]==1) {

                  echo '  <li class="menu-item">
                      <a href="file.php" class="menu-link">
                        <i class="menu-icon tf-icons bx bxs-hand"></i>
                        <div data-i18n="Analytics">For My Action</div>
                      </a>
                    </li>
                    <li class="menu-item">
                        <a href="accounts.php" class="menu-link">
                          <i class="menu-icon tf-icons bx bxs-like"></i>
                          <div data-i18n="Analytics">Account Approvals</div>
                        </a>
                      </li>';
                }

                 ?>



          </ul>
        </aside>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->

          <nav
            class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
            id="layout-navbar"
          >
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
              <!-- Search -->
              <div class="navbar-nav align-items-center">
                <div class="nav-item d-flex align-items-center">
                  <i class="bx bx-search fs-4 lh-0" hidden></i>
                  <input
                    type="text"
                    class="form-control border-0 shadow-none"
                    placeholder="Search..."
                    aria-label="Search..."
                    hidden
                  />
                </div>
              </div>
              <!-- /Search -->

              <ul class="navbar-nav flex-row align-items-center ms-auto">



                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                      <img src="<?php
                      if ($user->photoUrl!="") {
                        echo $photoURL;
                      }else{
                        echo "../assets/img/avatars/man.png";
                      }
                       ?>" alt class="w-px-40 h-auto rounded-circle" />
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="#">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">
                              <img src="<?php
                              if ($user->photoUrl!="") {
                                echo $photoURL;
                              }else{
                                echo "../assets/img/avatars/man.png";
                              }
                               ?>" alt class="w-px-40 h-auto rounded-circle" />
                            </div>
                          </div>
                          <div class="flex-grow-1">
                            <span class="fw-semibold d-block"><?php
                             echo $user->displayName;
                             ?></span>
                            <small class="text-muted"><?php if ($_SESSION['isAdmin']) {
                              echo "Admin";
                            }else{
                              echo "Non-Admin";
                            } ?></small>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="pages-account-settings-account.php">
                        <i class="bx bx-user me-2"></i>
                        <span class="align-middle">My Profile</span>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="logout.php">
                        <i class="bx bx-power-off me-2"></i>
                        <span class="align-middle">Log Out</span>
                      </a>
                    </li>
                  </ul>
                </li>
                <!--/ User -->
              </ul>
            </div>
          </nav>

          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
<div class="row">
  <!-- Basic Bootstrap Table -->
<?php
if (isset($_GET["file"])) {

}else{


 ?>


  <div class="card" id="tables">
    <h5 class="card-header">Files List</h5>
    <div class="table-responsive text-nowrap">
      <table class="table" id="dataTable">
        <thead>
          <tr>
            <th hidden></th>
            <th>Control No.</th>
            <th>Title</th>
            <th>Routed to</th>
            <th>Upload Date</th>
            <th>File Type</th>
            <th>Actions</th>
          </tr>
        </thead>

        <tbody class="table-border-bottom-0">
<?php
$fetchdata=$database->getReference('Files/')->getValue();
if($fetchdata!=null){
  krsort($fetchdata);

foreach ($fetchdata as $key => $row) {
  foreach ($row as $key1 => $row1) {
    foreach ($row1 as $key2 => $value) {
      $url=$storage->getBucket()->object($value['filename'])->signedUrl($expiresAt);
// $url="localhost:8080/dms2/dms/html/view.php?url=".$url;

if($user->displayName==$value['routedto']){



      echo "  <tr>
      <td hidden>".$value['filename']."</td>
      <td><strong>".$value['controlnumber']."</strong></td>
      <td>".$value['title']."</td>
      <td>";
      if($value['routedto']==""){
        echo "Unassigned";
      }else{
        echo $value["routedto"];
      }
      echo
      "</td>
        <td>".$value['uploaddate']."</td>
        <td>";
        $filetype=strtolower(substr($value['filename'],strpos($value['filename'],".")+1));

        if (strstr($filetype,'xls')!="") {
          echo '<div class="avatar flex-shrink-0 center">
            <img
              src="../assets/img/icons/unicons/xlsx.png"
              alt="chart success"
              class="rounded"
            />
          </div>';
        }elseif (strstr($filetype,'pdf')!="") {
          echo '<div class="avatar flex-shrink-0 center">
            <img
              src="../assets/img/icons/unicons/pdf.png"
              alt="chart success"
              class="rounded"
            />
          </div>';
        }elseif (strstr($filetype,'doc')!="") {
          echo '<div class="avatar flex-shrink-0 center">
            <img
              src="../assets/img/icons/unicons/doc.png"
              alt="chart success"
              class="rounded"
            />
          </div>';
        }elseif (strstr($filetype,'ppt')!="") {
          echo '<div class="avatar flex-shrink-0 center">
            <img
              src="../assets/img/icons/unicons/ppt.png"
              alt="chart success"
              class="rounded"
            />
          </div>';
        }


      echo  "</td>
      <td><a  href='".$_SESSION["env"]."/html/file.php?d=".$key."&file=".$value['controlnumber']."&q=".$key1."'><strong>View Info</strong></a>
| <a href='".$url."'><strong>Download</strong></a>";
if($_SESSION["isAdmin"]==2){
  echo "
  |<a  href='".$_SESSION["env"]."/html/public.php?d=".$key."&file=".$value['controlnumber']."&q=".$key1."&delete=true'><strong>Delete</strong></a>
  ";
}
echo"
      </td>
        </tr>
      ";
}
}
  }
}
}

 ?>


        </tbody>
      </table>
    </div>
  </div>




<?php
}
 ?>

  <!--/ Basic Bootstrap Table -->
</div>

            </div>
            <!-- / Content -->
            <!-- Modal -->
            <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                  <form class="" enctype="multipart/form-data" action="index.php" method="post">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Upload Files</h5>
                    <button
                      type="button"
                      class="btn-close"
                      data-bs-dismiss="modal"
                      aria-label="Close"
                    ></button>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <?php $control=date("Ymdhms"); ?>
                      <h3>Control #: <?php echo $control;  ?></h3>
                      <input type="text" name="controlnumber" value="<?php echo $control;  ?>" hidden>
                      <div class="col mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input
                          type="text"
                          name="uploaddate"
                          id="date"
                          class="form-control"
                          value="<?php echo date("Y-d-m"); ?>"
                          disabled
                        />
                      </div>
                    </div>
  <div class="row g-2">
  <div class="col mb-0">
    <label for="agency" class="form-label">Title:</label>
    <input type="text" id="title" name="title" class="form-control" placeholder="" required/>
  </div>
  </div>

                    <div class="row g-2">
                      <div class="col mb-0">
                        <label for="remarks" class="form-label">Received By:</label>
                        <input type="text" id="receivedby" name="receivedby" class="form-control" placeholder="" required/>
                      </div>
                      <!-- <div class="col mb-0">
                        <label for="exampleFormControlSelect1" class="form-label">Routed to</label>
                        <select class="form-select" name="routedto" id="exampleFormControlSelect1" aria-label="Routed to" required>
                          <option selected>Select</option>
                          <?php
                        //   $fetchdata=$database->getReference('USERS')->getValue();
                        // if($fetchdata>0){
                        //   foreach ($fetchdata as $key => $row) {
                        //     if ($row['position']!='Guest') {
                        //     echo '<option value="'.$row['name'].'">'.$row['name']." - ".$row['position'].'</option>';
                        //   }
                        //   }
                        // }
                           ?>
                        </select>
                      </div> -->
                    </div>

                    <div class="row g-2">
                      <div class="col mb-0">
                        <label for="agency" class="form-label">Office/Agency:</label>
                        <input type="text" id="agency" name="agency" class="form-control" placeholder="" required/>
                      </div>
                      <div class="col mb-0">
                        <label for="remarks" class="form-label">Remarks/Action:</label>
                        <input type="text" id="remarks" name="remarks" class="form-control" placeholder="" required/>
                      </div>
                    </div>
                    <!-- feedbacks -->
                    <!-- <label for="feedbacks" class="form-label">Feedbacks:</label>
                    <textarea class="form-control" name="feedbacks" id="feedbacks" rows="3"></textarea> -->
                    <!-- feedbacks -->

                    <!-- upload -->
                    <label for="formFile" class="form-label">Select Files</label>
                    <input class="form-control" type="file" accept=".xlsx,.xls,.doc, .docx,.ppt, .pptx,.pdf" id="filetoUpload" name="filetoUpload" required/>
                    <!-- upload -->

                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                      Close
                    </button>
                    <button type="submit" name="submit" class="btn btn-primary">Save changes</button>
                  </div>
                  </form>
                </div>
              </div>
            </div>
<!-- Modal -->
            <!-- Footer -->
            <footer class="content-footer footer bg-footer-theme">
              <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                <div class="mb-2 mb-md-0">
                Copyright  ©
                  <script>
                    document.write(new Date().getFullYear());
                  </script>
                  - eFileCabinet.gov
                </div>

              </div>
            </footer>
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->



    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets/vendor/libs/popper/popper.js"></script>
    <script src="../assets/vendor/js/bootstrap.js"></script>
    <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="../assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="../assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->
    <script src="../assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="../assets/js/dashboards-analytics.js"></script>

    <script src="../assets/datatables/jquery.dataTables.min.js"></script>
    <script src="../assets/datatables/dataTables.bootstrap4.min.js"></script>
    <!-- <script src="../assets/datatables/datatables-demo.js"></script> -->
    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
      $('#dataTable').DataTable({
          order: [[4, 'desc']],
      });
    });
    </script>
  </body>
</html>
