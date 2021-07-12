    <?php echo ($direction == 1 ? '<link rel="stylesheet" type="text/css" href="themes/'.$themes.'/css/style-rtl.css">' : '') ?>
    <link rel="stylesheet" type="text/css" href="themes/2020/css/style.css">
  </head>

  <body>
<div id="wrapper">
<?php if (isset($_COOKIE['projo'])) {
echo'
  <nav class="navbar navbar-expand-lg fixed-top navbar-light p-0" style="background-color: #0003;">
    <a class="logo-menu" href="./">
      <img src="themes/2020/img/logo.png">
    </a>
    <a class="btn btn-light btn-proj m-1" href="./">
      <i class="fal fa-home align-middle"></i>
    </a>
    <a class="btn btn-light btn-proj drop-after-none dropdown-toggle btn btn-light btn-proj btn-project-list" href="javascript:" id="navbarDropdown3" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="showProject()">
      <i class="fal fa-tasks-alt align-middle"></i>
      <span> '.$_PROJECTS.'</span>
    </a>
    <div class="dropdown-menu project-menu-drop" aria-labelledby="navbarDropdown3" id="show_project_menu">
      
    </div>
    <!-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button> -->

      <ul class="navbar-nav mr-auto">
        <li class="nav-item m-1">
          <a class="btn btn-light btn-proj drop-after-none dropdown-toggle" href="#" id="navbarDropdown2" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fal fa-info-circle align-middle"></i>
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown2" style="left: 93px;">';
            if ($permissions[0]['asuper_admin']==1) {
            echo'
              <a class="dropdown-item" href="admins.php?op=list">'.$_LIST.' '.$_ADMINS.'</a>
              <a class="dropdown-item" href="settings.php?op=settings">'.$_SETTING.' '.$_SISTEM.'</a>
              <a class="dropdown-item" href="issue_types.php?op=list">
                '.$_TYPE.' '.$_ISSUE.'
              </a>';
            }
            echo'
            <a class="dropdown-item" href="settings.php?op=about">'.$_ABOUT_ME.'</a>
          </div>
        </li>
        <li class="nav-item dropdown ml-1 mt-1">
          <a class="btn btn-light btn-proj drop-after-none dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fal fa-plus align-middle"></i>
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            '.($permissions[0]['allow_add_project'] == 1 ? '<a class="dropdown-item" href="javascript: openAddProject()">'.$_ADD.' '.$_PROJECT.'</a>' :'').'
            <div class="dropdown-divider"></div>
            '.($permissions[0]['asuper_admin'] == 1 ? '<a class="dropdown-item" href="admins.php?op=add">'.$_ADD.' '.$_ADMIN.'</a>' : '').'
          </div>
        </li>
        <li class="nav-item dropdown m-1">
          <a class="dropdown-toggle user-menu-profile drop-after-none" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
          if(file_exists('img/admins/'.$pic_prefix.$permissions[0]['apic'].''))
          {
            echo '<img src="img/admins/'.$pic_prefix.$permissions[0]['apic'].'">';
          }
          else{
            echo '<img src="img/admin.png">';
          }
          echo'
          </a>

          <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
            <h5 class="dropdown-header">'.$permissions[0]['afname'].' '.$permissions[0]['alname'].'</h5>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="settings.php?op=profile">'.$_EDIT.' '.$_PROFILE.'</a>
            <a class="dropdown-item" href="logout.php">'.$_LOGOUT.'</a>
          </div>
        </li>
      </ul>
    <!-- <div class="collapse navbar-collapse" id="navbarSupportedContent">
    </div> -->
  </nav>';
} 
echo '
<!-- Modal add project -->
<div class="modal fade modal-add-project" id="show_add_project" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form id="project" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-8">
                            <div class="card card-body example-new-card">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position: absolute; left: 10px; top: 10px; color: #fff">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <input type="text" class="form-control" id="title-project" name="title-project" placeholder="'. $_PROJECT_TITLE .'">
                                <input type="hidden" name="op" value="add_project">
                                <div class="upload-btn-wrapper">
                                    <label for="logo" class="btn">'. $_LOGO .'</label>
                                    <input type="file" name="logo" id="logo">
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group form-check bg-color-project">
                            <span>
                                <input type="radio" class="form-check-input" name="bg_color_project" id="bg_color_project_mini_1" value="fd7e14" checked>
                                <label class="form-check-label" for="bg_color_project_mini_1" onclick="activeColorMini(1)">
                                    <span class="box-color" style="background-color: #fd7e14">
                                        <i class="fal fa-check" id="check_bg_color_project_add_1" style="display: block"></i>
                                    </span>
                                </label>
                            </span>
                                <span>
                                <input type="radio" class="form-check-input" name="bg_color_project" id="bg_color_project_mini_2" value="007bff">
                                <label class="form-check-label" for="bg_color_project_mini_2" onclick="activeColorMini(2)">
                                    <span class="box-color" style="background-color: #007bff">
                                        <i class="fal fa-check" id="check_bg_color_project_add_2"></i>
                                    </span>
                                </label>
                            </span>
                                <span>
                                <input type="radio" class="form-check-input" name="bg_color_project" id="bg_color_project_mini_3" value="6f42c1">
                                <label class="form-check-label" for="bg_color_project_mini_3" onclick="activeColorMini(3)">
                                    <span class="box-color" style="background-color: #6f42c1">
                                        <i class="fal fa-check" id="check_bg_color_project_add_3"></i>
                                    </span>
                                </label>
                            </span>
                                <span>
                                <input type="radio" class="form-check-input" name="bg_color_project" id="bg_color_project_mini_4" value="dc3545">
                                <label class="form-check-label" for="bg_color_project_mini_4" onclick="activeColorMini(4)">
                                    <span class="box-color" style="background-color: #dc3545">
                                        <i class="fal fa-check" id="check_bg_color_project_add_4"></i>
                                    </span>
                                </label>
                            </span>
                                <span>
                                <input type="radio" class="form-check-input" name="bg_color_project" id="bg_color_project_mini_5" value="ffc107">
                                <label class="form-check-label" for="bg_color_project_mini_5" onclick="activeColorMini(5)">
                                    <span class="box-color" style="background-color: #ffc107">
                                        <i class="fal fa-check" id="check_bg_color_project_add_5"></i>
                                    </span>
                                </label>
                            </span>
                                <span>
                                <input type="radio" class="form-check-input" name="bg_color_project" id="bg_color_project_mini_6" value="28a745">
                                <label class="form-check-label" for="bg_color_project_mini_6" onclick="activeColorMini(6)">
                                    <span class="box-color" style="background-color: #28a745">
                                        <i class="fal fa-check" id="check_bg_color_project_add_6"></i>
                                    </span>
                                </label>
                            </span>
                                <span>
                                <input type="radio" class="form-check-input" name="bg_color_project" id="bg_color_project_mini_7" value="17a2b8">
                                <label class="form-check-label" for="bg_color_project_mini_7" onclick="activeColorMini(7)">
                                    <span class="box-color" style="background-color: #17a2b8">
                                        <i class="fal fa-check" id="check_bg_color_project_add_7"></i>
                                    </span>
                                </label>
                            </span>
                                <span>
                                <input type="radio" class="form-check-input" name="bg_color_project" id="bg_color_project_mini_8" value="20c997">
                                <label class="form-check-label" for="bg_color_project_mini_8" onclick="activeColorMini(8)">
                                    <span class="box-color" style="background-color: #20c997">
                                        <i class="fal fa-check" id="check_bg_color_project_add_8"></i>
                                    </span>
                                </label>
                            </span>
                            </div>
                        </div>
                    </div>
                    <div id="show-resault-add_project"></div>
                    <button class="btn btn-success">'. $_CREATE_PROJECT .'</button>
                </form>
            </div>
        </div>
    </div>
</div>
';
?>

<div id="page-wrapper">
    <div class="container-fluid pt-5">
        <!-- Page Heading -->
        <div class="row" id="main">