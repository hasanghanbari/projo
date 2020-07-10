<?php if (isset($_COOKIE['iproject'])) {
echo'
<div class="nav-side-menu">
    <a href="./" style="color: #fff;"><div class="brand">'.$system_title.'</div></a>
    <i class=" glyphicon glyphicon-menu-hamburger fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>
  
        <div class="menu-list">
  
            <ul id="menu-content" class="menu-content collapse out">
                <a href="./">
                  <li>
                    <i></i><span class="glyphicon glyphicon-dashboard" aria-hidden="true"></span> '._DASHBOARD.'
                  </li>
                </a>
                  ';
                if ($permissions[0]['allow_add_project']!=0 || $permissions[0]['allow_list_project']!=0) {
                echo'
                <li  data-toggle="collapse" data-target="#products" class="collapsed">
                  <a><i></i><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> '._PROJECT.' <span class="glyphicon glyphicon-chevron-down"></span></a>
                </li>
                <ul class="sub-menu collapse" id="products">';
                  if ($permissions[0]['allow_add_project']==1) {
                    echo'<a href="projects.php?op=add"><li><i></i><span class=" glyphicon glyphicon-menu-right" aria-hidden="true"></span> '._ADD.' '._PROJECT.'</li></a>';
                  }
                  if ($permissions[0]['allow_list_project']==1) {
                  echo'
                    <a href="projects.php?op=list"><li><i></i><span class=" glyphicon glyphicon-menu-right" aria-hidden="true"></span> '._LIST.' '._PROJECTS.'‌</li></a>';
                  }
                  echo'
                </ul>';
                }
                if ($permissions[0]['allow_add_task']!=0 || $permissions[0]['allow_list_task']!=0) {
                echo'
                <li data-toggle="collapse" data-target="#tasks" class="collapsed">
                  <a><i></i><span class="glyphicon glyphicon-tasks" aria-hidden="true"></span> '._TASK.' <span class="glyphicon glyphicon-chevron-down"></span></a>
                </li>  
                <ul class="sub-menu collapse" id="tasks">';
                if ($permissions[0]['allow_add_task']==1) {
                  echo'<a href="tasks.php?op=add"><li><i></i><span class=" glyphicon glyphicon-menu-right" aria-hidden="true"></span> '._ADD.' '._TASK.'</li></a>';
                }
                if ($permissions[0]['allow_list_task']==1) {
                  echo'
                  <a href="tasks.php?op=list"><li><i></i><span class=" glyphicon glyphicon-menu-right" aria-hidden="true"></span> '._LIST.' '._TASKS.'</li></a>
                  <a href="tasks.php?op=chart"><li><i></i><span class=" glyphicon glyphicon-menu-right" aria-hidden="true"></span> '._CHART.' '._TASKS.'</li></a>
                  ';
                }
                echo'
                </ul>';
                }
                if ($permissions[0]['allow_add_issues']!=0 || $permissions[0]['allow_list_issues']!=0 || $permissions[0]['asuper_admin']!=0) {
                  echo'
                  <li data-toggle="collapse" data-target="#service" class="collapsed">
                    <a><i></i><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> '._ISSUE.' <span class="glyphicon glyphicon-chevron-down"></span></a>
                  </li>  
                  <ul class="sub-menu collapse" id="service">';
                  if ($permissions[0]['allow_add_issues']==1) {
                    echo'
                    <a href="issues.php?op=add"><li><i></i><span class=" glyphicon glyphicon-menu-right" aria-hidden="true"></span> '._ADD.' '._ISSUE.'</li></a>';
                    }
                  if ($permissions[0]['allow_list_issues']==1) {
                    echo'
                    <a href="issues.php?op=list"><li><i></i><span class=" glyphicon glyphicon-menu-right" aria-hidden="true"></span> '._LIST.' '._ISSUES.'</li></a>
                    <a href="issues.php?op=chart"><li><i></i><span class=" glyphicon glyphicon-menu-right" aria-hidden="true"></span> '._CHART.' '._ISSUES.'</li></a>
                    <a href="issues.php?op=list&archive"><li><i></i><span class=" glyphicon glyphicon-menu-right" aria-hidden="true"></span> '._ARCHIVE.' '._ISSUES.'</li></a>';
                  }
                  if ($permissions[0]['asuper_admin']==1) {
                  echo'
                    <a href="issue_types.php?op=add"><li><i></i><span class=" glyphicon glyphicon-menu-right" aria-hidden="true"></span> '._ADD.' '._TYPE.' '._ISSUE.'</li></a>
                    <a href="issue_types.php?op=list"><li><i></i><span class=" glyphicon glyphicon-menu-right" aria-hidden="true"></span> '._TYPE.' '._ISSUE.'</li></a>';
                  }
                  echo'
                  </ul>';
                }
                if ($permissions[0]['asuper_admin']==1) {
                  echo'
                  <li data-toggle="collapse" data-target="#admin" class="collapsed">
                    <a><i></i><span class="glyphicon glyphicon-user" aria-hidden="true"></span> '._ADMINS.' <span class="glyphicon glyphicon-chevron-down"></span></a>
                  </li>
                  <ul class="sub-menu collapse" id="admin">
                    <a href="admins.php?op=add"><li><i></i><span class=" glyphicon glyphicon-menu-right" aria-hidden="true"></span> '._ADD.' '._ADMIN.'</li></a>
                    <a href="admins.php?op=list"><li><i></i><span class=" glyphicon glyphicon-menu-right" aria-hidden="true"></span> '._LIST.' '._ADMINS.'</li></a>
                  </ul>';
                }
                echo'
                <li data-toggle="collapse" data-target="#setting" class="collapsed">
                  <a><i></i><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span> '._SETTING.' <span class="glyphicon glyphicon-chevron-down"></span></a>
                </li>
                <ul class="sub-menu collapse" id="setting">';
                if ($permissions[0]['asuper_admin']==1) {
                echo'
                  <a href="settings.php?op=settings"><li><i></i><span class=" glyphicon glyphicon-menu-right" aria-hidden="true"></span> '._SETTING.' '._SISTEM.'</li></a>';
                }
                echo'
                  <a href="settings.php?op=about"><li><i></i><span class=" glyphicon glyphicon-menu-right" aria-hidden="true"></span> '._ABOUT_ME.'</li></a>
                </ul>
                <a href="settings.php?op=profile">
                  <li>
                    <i></i><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> '._EDIT.' '._PROFILE.'
                  </li>
                </a>

                <a href="logout.php">
                  <li>
                    <i></i><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> '._LOGOUT.'
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