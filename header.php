<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo _ABOUT_PROJA_SYSTEM_NAME2 ?></title>

    <link rel="stylesheet" type="text/css" href="vendor/Persian-Jalali/style/kamadatepicker.min.css" >
    <link rel="stylesheet" href="vendor/fontawesome-5.13.0/css/all.min.css" />

    <link rel="shortcut icon" href="themes/2020/img/logo.png">

    <!-- TOAST -->
    <link rel="stylesheet" type="text/css" href="vendor/toast/jquery.toast.min.css">

    <link rel="stylesheet" type="text/css" href="vendor/bootstrap-4.5.0/css/bootstrap.min.css">

    <script src="vendor/jquery-3.5.1.min.js"></script>

    <script src="vendor/popper.min.js"></script>

    <script src="vendor/bootstrap-4.5.0/js/bootstrap.min.js"></script>

    <script>
    function Sure() {
      if (confirm(" <?php echo _ARE_YOU_SURE_DELETE ?> "))
        return true;
      else
        return false;
    }
  </script>
  <script>
    function checkAll(bx) {
      var cbs = document.getElementsByTagName('input');
      for(var i=0; i < cbs.length; i++) {
        if(cbs[i].type == 'checkbox') {
          cbs[i].checked = bx.checked;
        }
      }
    }
  </script>

  <style>
  <?php
  date_default_timezone_set('UTC');
    echo '
      body{
        direction: '.$dir.';
        font-family: '.($language != 'farsi'?'Corbel,Times New Roman (Headings CS)':'Samim').';
      }
      .nav-side-menu{
        font-family: '.($language != 'farsi'?'Corbel,Times New Roman (Headings CS)':'Samim').';
        '.$align1.': 0px;
      }';
      if ($direction==0){
       echo' 
        #main{
          clear: both;
          margin-right: -270px;
          margin-left: 230px;
        }
        @media (max-width: 767px) {
          #main{
            clear: both;
            margin-right: -15px;
            margin-left: -15px;
          }
        }
      ';
      }
    echo '
      .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9 {
          float: '.$align1.';
      }';
  ?>
  </style>
  <?php
  echo'
    <!-- TOAST -->
  <script type="text/javascript" src="vendor/toast/jquery.toast.min.js"></script>
  <script>
    tinymce.init({
        selector: \'.editor\',';
        if ($language == 'farsi') {
          echo'
          language: \'fa_IR\',
          directionality : \'rtl\',
          ';
        }
        echo'
        height: 200,
        theme: \'modern\',
        plugins: \'print preview searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools contextmenu colorpicker textpattern help directionality\',
        toolbar1: \'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat | ltr rtl\',
        image_advtab: true,
        templates: [
        { title: \'Test template 1\', content: \'Test 1\' },
        { title: \'Test template 2\', content: \'Test 2\' }
        ],
        content_css: [
        \'//fonts.googleapis.com/css?family=Lato:300,300i,400,400i\',
        \'//www.tinymce.com/css/codepen.min.css\'
        ]
    });
  </script>
  ';
     ?>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="themes/default/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="themes/default/css/dashboard.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="themes/default/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <?php echo ($direction == 1 ? '<link rel="stylesheet" type="text/css" href="themes/'.$themes.'/css/font-iran.css">' : '') ?>

    <link rel="stylesheet" type="text/css" href="themes/2020/css/style.css">
    
    <?php echo ($direction == 1 ? '<link rel="stylesheet" type="text/css" href="themes/'.$themes.'/css/style-rtl.css">' : '') ?>
  </head>

  <body>
<div id="wrapper">
