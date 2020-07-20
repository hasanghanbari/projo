<?php if (isset($_COOKIE['iproject'])) {?>
<div class="nav-side-menu">
    <div class="brand">iProject</div>
    <i class="fas fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>
  
        <div class="menu-list">
  
            <ul id="menu-content" class="menu-content collapse out">
                <li>
                  <a href="../">
                  <i></i> پیشخوان
                  </a>
                </li>

                <li  data-toggle="collapse" data-target="#products" class="collapsed active">
                  <a href="#"><i></i> پروژه <span class="fas fa-chevron-down"></span></a>
                </li>
                <ul class="sub-menu collapse" id="products">
                    <li><a href="projects.php?op=add">افزودن پروژه</a></li>
                    <li><a href="projects.php?op=list">لیست پروژه‌ها</a></li>
                    <li><a href="projects.php?op=arshive">آرشیو پروژه‌ها</a></li>
                </ul>


                <li data-toggle="collapse" data-target="#service" class="collapsed">
                  <a href="#"><i></i> مسائل <span class="fas fa-chevron-down"></span></a>
                </li>  
                <ul class="sub-menu collapse" id="service">
                  <li><a href="issues.php?op=add">افزودن مسئله</a></li>
                  <li><a href="issues.php?op=list">لیست مسائل</a></li>
                  <li><a href="issues.php?op=arshive">آرشیو مسائل</a></li>
                </ul>

                <li data-toggle="collapse" data-target="#admin" class="collapsed">
                  <a href="#"><i></i> مدیران <span class="fas fa-chevron-down"></span></a>
                </li>
                <ul class="sub-menu collapse" id="admin">
                  <li><a href="admins.php?op=add">افزودن مدیر</a></li>
                  <li><a href="admins.php?op=list">لیست مدیران</a></li>
                </ul>


                 <li>
                  <a href="#">
                  <i></i> ویرایش پروفایل
                  </a>
                  </li>

                 <li>
                  <a href="logout.php">
                  <i></i> خروج
                  </a>
                </li>
            </ul>
     </div>
</div>
<?php } ?>
<div id="page-wrapper">
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row" id="main">