    <?php echo ($direction == 1 ? '<link rel="stylesheet" type="text/css" href="themes/'.$themes.'/css/style-rtl.css">' : '') ?>
    <link rel="stylesheet" type="text/css" href="themes/2020/css/style.css">
  </head>

  <body>
<div id="wrapper">
<?php if (isset($_COOKIE['iproject'])) {
echo'
<div class="nav-side-menu">
    <a href="./" style="color: #fff;"><div class="brand">'.$system_title.'</div></a>
    <i class=" fal fa-menu-hamburger fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>
        <div class="menu-list accordion" id="">
  
            <ul id="accordionMenu" class="menu-content collapse out">
                <a href="./">
                  <li>
                    <i class="fas fa-tachometer-fast" aria-hidden="true"></i>
                     '._DASHBOARD.'
                  </li>
                </a>
                  ';
                if ($permissions[0]['allow_add_project']!=0 || $permissions[0]['allow_list_project']!=0) {
                echo'
                <li id="headingOne" data-toggle="collapse" data-target="#products" aria-controls="#products" data-parent="#accordionMenu" class="collapsed">
                  <a>
                    <i class="fas fa-list-alt" aria-hidden="true"></i>
                     <span class="menu-title">'._PROJECT.' </span>
                    <i class="fas fa-arrow-down menu-arrow-down"></i>
                  </a>
                </li>
                <ul class="sub-menu collapse" id="products" aria-labelledby="headingOne">';
                  if ($permissions[0]['allow_add_project']==1) {
                    echo'
                    <a href="projects.php?op=add">
                      <li>
                        <i class=" fal fa-menu-right" aria-hidden="true"></i>
                         '._ADD.' '._PROJECT.'
                      </li>
                    </a>';
                  }
                  if ($permissions[0]['allow_list_project']==1) {
                  echo'
                    <a href="projects.php?op=list">
                      <li>
                        <i class=" fal fa-menu-right" aria-hidden="true"></i>
                         '._LIST.' '._PROJECTS.'‌
                      </li>
                    </a>';
                  }
                  echo'
                </ul>';
                }
                if ($permissions[0]['allow_add_task']!=0 || $permissions[0]['allow_list_task']!=0) {
                echo'
                <li data-toggle="collapse" data-target="#tasks" class="collapsed">
                  <a>
                    <i class="fas fa-tasks" aria-hidden="true"></i>
                     <span class="menu-title">'._TASK.' </span>
                      <i class="fas fa-arrow-down menu-arrow-down"></i>
                  </a>
                </li>  
                <ul class="sub-menu collapse" id="tasks">';
                if ($permissions[0]['allow_add_task']==1) {
                  echo'
                  <a href="tasks.php?op=add">
                    <li>
                      <i class=" fal fa-menu-right" aria-hidden="true"></i>
                       '._ADD.' '._TASK.'
                    </li>
                  </a>';
                }
                if ($permissions[0]['allow_list_task']==1) {
                  echo'
                  <a href="tasks.php?op=list">
                    <li>
                      <i class=" fal fa-menu-right" aria-hidden="true"></i>
                       '._LIST.' '._TASKS.'
                    </li>
                  </a>
                  <a href="tasks.php?op=chart">
                    <li>
                      <i class=" fal fa-menu-right" aria-hidden="true"></i>
                       '._CHART.' '._TASKS.'
                    </li>
                  </a>
                  ';
                }
                echo'
                </ul>';
                }
                if ($permissions[0]['allow_add_issues']!=0 || $permissions[0]['allow_list_issues']!=0 || $permissions[0]['asuper_admin']!=0) {
                  echo'
                  <li data-toggle="collapse" data-target="#service" class="collapsed">
                    <a>
                      <i class="fas fa-info-circle" aria-hidden="true"></i>
                       <span class="menu-title">'._ISSUE.' </span>
                        <i class="fas fa-arrow-down menu-arrow-down"></i>
                    </a>
                  </li>  
                  <ul class="sub-menu collapse" id="service">';
                  if ($permissions[0]['allow_add_issues']==1) {
                    echo'
                    <a href="issues.php?op=add">
                      <li>
                        <i class=" fal fa-menu-right" aria-hidden="true"></i>
                         '._ADD.' '._ISSUE.'
                      </li>
                    </a>';
                    }
                  if ($permissions[0]['allow_list_issues']==1) {
                    echo'
                    <a href="issues.php?op=list">
                      <li>
                        <i class=" fal fa-menu-right" aria-hidden="true"></i>
                         '._LIST.' '._ISSUES.'
                      </li>
                    </a>
                    <a href="issues.php?op=chart">
                      <li>
                        <i class=" fal fa-menu-right" aria-hidden="true"></i>
                         '._CHART.' '._ISSUES.'
                      </li>
                    </a>
                    <a href="issues.php?op=list&archive">
                      <li>
                        <i class=" fal fa-menu-right" aria-hidden="true"></i>
                         '._ARCHIVE.' '._ISSUES.'
                      </li>
                    </a>';
                  }
                  if ($permissions[0]['asuper_admin']==1) {
                  echo'
                    <a href="issue_types.php?op=add">
                      <li>
                        <i class=" fal fa-menu-right" aria-hidden="true"></i>
                         '._ADD.' '._TYPE.' '._ISSUE.'
                      </li>
                    </a>
                    <a href="issue_types.php?op=list">
                      <li>
                        <i class=" fal fa-menu-right" aria-hidden="true"></i>
                         '._TYPE.' '._ISSUE.'
                      </li>
                    </a>';
                  }
                  echo'
                  </ul>';
                }
                if ($permissions[0]['asuper_admin']==1) {
                  echo'
                  <li data-toggle="collapse" data-target="#admin" class="collapsed">
                    <a>
                      <i class="fas fa-user" aria-hidden="true"></i>
                       <span class="menu-title">'._ADMINS.' </span>
                      <i class="fas fa-arrow-down menu-arrow-down"></i>
                    </a>
                  </li>
                  <ul class="sub-menu collapse" id="admin">
                    <a href="admins.php?op=add">
                      <li>
                        <i class=" fal fa-menu-right" aria-hidden="true"></i>
                         '._ADD.' '._ADMIN.'
                      </li>
                    </a>
                    <a href="admins.php?op=list">
                      <li>
                        <i class=" fal fa-menu-right" aria-hidden="true"></i>
                         '._LIST.' '._ADMINS.'
                      </li>
                    </a>
                  </ul>';
                }
                echo'
                <li data-toggle="collapse" data-target="#setting" class="collapsed">
                  <a>
                      <i class="fas fa-wrench" aria-hidden="true"></i>
                      <span class="menu-title">'._SETTING.' </span>
                      <i class="fas fa-arrow-down menu-arrow-down"></i>
                  </a>
                </li>
                <ul class="sub-menu collapse" id="setting">';
                if ($permissions[0]['asuper_admin']==1) {
                echo'
                  <a href="settings.php?op=settings">
                    <li>
                      <i class=" fal fa-menu-right" aria-hidden="true"></i>
                       '._SETTING.' '._SISTEM.'
                    </li>
                  </a>';
                }
                echo'
                  <a href="settings.php?op=about">
                    <li>
                      <i class=" fal fa-menu-right" aria-hidden="true"></i>
                       '._ABOUT_ME.'
                    </li>
                  </a>
                </ul>
                <a href="settings.php?op=profile">
                  <li>
                    
                    <i class="fas fa-user-edit" aria-hidden="true"></i>
                    <span class="menu-title">'._EDIT.' '._PROFILE.'</span>
                  </li>
                </a>

                <a href="logout.php">
                  <li>
                    
                    <i class="fas fa-sign-out-alt" aria-hidden="true"></i>
                     <span class="menu-title">'._LOGOUT.'</span>
                  </li>
                </a>
            </ul>
     </div>
</div>';
} 

?>
<div id="page-wrapper">
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row" id="main">