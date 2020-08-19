    <?php echo ($direction == 1 ? '<link rel="stylesheet" type="text/css" href="themes/'.$themes.'/css/style-rtl.css">' : '') ?>
    <link rel="stylesheet" type="text/css" href="themes/2020/css/style.css">
  </head>

  <body>
<div id="wrapper">
<?php if (isset($_COOKIE['iproject'])) {
echo'
  <nav class="navbar navbar-expand-lg fixed-top navbar-light p-0" style="background-color: #0003;">
    <a class="navbar-brand" href="./">
      <img src="themes/2020/img/logo.png">
    </a>
    <a class="btn btn-light btn-proj m-1" href="./">
      <i class="fal fa-home align-middle"></i>
    </a>
    <a class="btn btn-light btn-proj drop-after-none dropdown-toggle btn btn-light btn-proj" href="#" id="navbarDropdown3" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <i class="fal fa-tasks-alt align-middle"></i> پروژه‌ها
    </a>
    <div class="dropdown-menu" aria-labelledby="navbarDropdown3">
      <a class="dropdown-item" href="#">افزودن پروژه</a>
    </div>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item m-1">
          <a class="btn btn-light btn-proj drop-after-none dropdown-toggle" href="#" id="navbarDropdown2" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fal fa-info-circle align-middle"></i>
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown2">
            '.($permissions[0]['asuper_admin'] == 1 ? '<a class="dropdown-item" href="settings.php?op=settings">'._SETTING.' '._SISTEM.'</a>' : '').'
            <a class="dropdown-item" href="settings.php?op=about">'._ABOUT_ME.'</a>
          </div>
        </li>
        <li class="nav-item dropdown ml-1 mt-1">
          <a class="btn btn-light btn-proj drop-after-none dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fal fa-plus align-middle"></i>
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            '.($permissions[0]['allow_add_project'] == 1 ? '<a class="dropdown-item" href="javascript: openAddProject()">'._ADD.' '._PROJECT.'</a>' :'').'
            '.($permissions[0]['allow_add_task'] == 1 ? '<a class="dropdown-item" href="tasks.php?op=add">'._ADD.' '._TASK.'</a>' : '').'
            <div class="dropdown-divider"></div>
            '.($permissions[0]['asuper_admin'] == 1 ? '<a class="dropdown-item" href="admins.php?op=add">'._ADD.' '._ADMIN.'</a>' : '').'
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
            <a class="dropdown-item" href="settings.php?op=profile">'._EDIT.' '._PROFILE.'</a>
            <a class="dropdown-item" href="logout.php">'._LOGOUT.'</a>
          </div>
        </li>
      </ul>
    </div>
  </nav>';
} 

?>
<div id="page-wrapper">
    <div class="container-fluid pt-5">
        <!-- Page Heading -->
        <div class="row" id="main">