<!DOCTYPE html>
<html>
<head>
	<title>تست</title>
	<meta charset="utf-8">
	<script src="../themes/default/js/jquery.min.js"></script>
	<script>
     function IssueInfo() {
       $("#vqs").html('<img src="../img/wait.gif">');
		   var issue_id= $("#issue_id").val();
       $.ajax({
         url: "aj.php",
         type: "POST",
         data: {op:"issue_prjid",fname:fname},
         SUCCESS: function(data,status) {
           $("#vqs").html(data);
         },
         error: function() {$("#vqs").html("problem in ajax")}
       });
     }
    </script>
</head>
<body dir="rtl">
نام: <input type="text" name="fname" id="fname">
نام خانوادگی: <input type="text" name="lname" id="lname">
<input type="submit" name="add" value="send" onclick="IssueInfo()">
<div id="vqs"></div>
</body>
</html>