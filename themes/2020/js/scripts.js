$(document).ready(function() {
    $('.editor').richText();
    $('madal .editor').richText();
});

// In your Javascript (external .js resource or <script> tag)
$(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});

/*
* * Function that gets the data of the profile in case 
* thar it has already saved in localstorage. Only the 
* UI will be update in case that all data is available 
* * A not existing key in localstorage return null * 
*/
function getLocalProfile(callback){
    var profileImgSrc      = localStorage.getItem("PROFILE_IMG_SRC");
    var profileName        = localStorage.getItem("PROFILE_NAME");    
    var profileReAuthEmail = localStorage.getItem("PROFILE_REAUTH_EMAIL");    
    if(profileName !== null&& profileReAuthEmail !== null&& profileImgSrc !== null) 
    {
    	callback(profileImgSrc, profileName, profileReAuthEmail);
    }
}

function AddIssueBox(tskid) {
    $("#addIssueButton"+tskid).hide();
    $("#addIssueText"+tskid).show();
    $("#issueText"+tskid).val("");
    $("#confirmIssueButton"+tskid).attr("disabled", false);
    $("#showWait"+tskid).hide();
    $("#showBtnText"+tskid).show();
}

function CancelIssueBox(tskid) {
    $("#addIssueButton"+tskid).show();
    $("#addIssueText"+tskid).hide();
    $("#issueText"+tskid).val("");
    $("#confirmIssueButton"+tskid).attr("disabled", false);
    $("#showWait"+tskid).hide();
    $("#showBtnText"+tskid).show();
}
function openAddCase() {
    $("#show_add_task").modal()
}

function addTask(prjid, aid, title=null) {
    const task_title = (title == null ? $("#modal_new_task").val() : title);
    $("#show-response-add-task").html('<img src="img/wait.gif">');
    $.ajax({
        url: "aj.php",
        type: "POST",
        data: { 
            op:"add_task", task_title:task_title, prjid: prjid, aid: aid
        },
        success: function(data,status) {
            $("#show-response-add-task").html(data);
        },
        error: function() {
            $("#show-response-add-task").html("problem in ajax")
        }
    });
}
function AddIssue(tskid, prjid) {
    const issueText = $("#issueText"+tskid).val();

    $("#showWait"+tskid).show();
    $("#showBtnText"+tskid).hide();
    $("#showWait"+tskid).html('<img src="img/wait.gif">');
    $("#confirmIssueButton"+tskid).attr("disabled", true);

    $.ajax({
        url: "aj.php",
        type: "POST",
        data: { 
            op:"add_issue", tskid:tskid, issueText: issueText, prjid: prjid
        },
        success: function(data,status) {
            $("#showWait"+tskid).html(data);
            IssueList(tskid);
            CancelIssueBox(tskid);
        },
        error: function() {
            $("#showWait"+tskid).html("problem in ajax")
        }
    });
}
function IssueList(tskid) {
    $("#issueList"+tskid).html('<img src="img/wait.gif">');
    $.ajax({
        url: "aj.php",
        type: "POST",
        data: { 
            op:"issue_list", tskid:tskid
        },
        success: function(data,status) {
            $("#issueList"+tskid).html(data);
        },
        error: function() {
            $("#issueList"+tskid).html("problem in ajax")
        }
    });
}
  function IssueInfo(id, tskid) {
    $("#show_chart_issue").modal()
    $("#show-issue-info-modal").html('<img src="img/wait.gif">');
    $.ajax({
      url: "aj.php",
      type: "POST",
      data: {op:"issue_info",issue_id:id, tskid: tskid},
      success: function(data,status) {
        $("#show-issue-info-modal").html(data);
      },
      error: function() {$("#show-issue-info-modal").html("problem in ajax")}
    });
  }
function doneIssue(id, tskid) {
    $("#show-resault-done-issue").html('<img src="img/wait.gif">');
    $.ajax({
      url: "aj.php",
      type: "POST",
      data: {op:"done_issue", iid: id, tskid: tskid},
      success: function(data,status) {
        $("#show-resault-done-issue").html(data);
      },
      error: function() {$("#show-resault-done-issue").html("problem in ajax")}
    });
}
function startIssue(id, tskid) {
    $("#show-resault-done-issue").html('<img src="img/wait.gif">');
    $.ajax({
      url: "aj.php",
      type: "POST",
      data: {op:"start_issue", iid: id, tskid: tskid},
      success: function(data,status) {
        $("#show-resault-done-issue").html(data);
      },
      error: function() {$("#show-resault-done-issue").html("problem in ajax")}
    });
}
function deleteProject(id) {
    $("#show-resault-delete_project").html('<img src="img/wait.gif">');
    $.ajax({
      url: "aj.php",
      type: "POST",
      data: {op:"delete_project", prjid: id},
      success: function(data,status) {
        $("#show-resault-delete_project").html(data);
        window.location = "index.php";
      },
      error: function() {$("#show-resault-delete_project").html("problem in ajax")}
    });
}
function deleteIssue(id, tskid) {
    $("#show-resault-done-issue").html('<img src="img/wait.gif">');
    $.ajax({
      url: "aj.php",
      type: "POST",
      data: {op:"delete_issue", iid: id, tskid: tskid},
      success: function(data,status) {
        $("#show-resault-done-issue").html(data);
        $("#show_chart_issue").modal('hide');
      },
      error: function() {$("#show-resault-done-issue").html("problem in ajax")}
    });
}
function deleteTask(tskid) {
    $("#show-resault-delete_task").html('<img src="img/wait.gif">');
    $.ajax({
      url: "aj.php",
      type: "POST",
      data: {op:"delete_task", tskid: tskid},
      success: function(data,status) {
        $("#show-resault-delete_task").html(data);
        location.reload();
      },
      error: function() {$("#show-resault-delete_task").html("problem in ajax")}
    });
}
function editTask(id) {
  $("#show_edit_task").modal()
  $.ajax({
    url: "aj.php",
    type: "POST",
    data: {op:"edit_task_form", tskid: id},
    success: function(data,status) {
      $("#show-resault-edit_task").html(data);
      $(".js-example-basic-multiple-user").select2({
        placeholder: 'انتخاب مدیرانی که دسترسی دارند'
      });
    },
    error: function() {$("#show-resault-edit_task").html("problem in ajax")}
  });
}
function openAddProject() {
    $("#show_add_project").modal()
}
function showProject() {
  console.log('showProject');
  $("#show_project_menu").html('<img src="img/wait.gif">');
  $.ajax({
    url: "aj.php",
    type: "POST",
    data: {op:"list_project_menu"},
    success: function(data,status) {
      $("#show_project_menu").html(data);
    },
    error: function() {$("#show_project_menu").html("problem in ajax")}
  }); 
}
function activeColor(id) {
  const color = $("#bg_color_project" + id).val();
  $(".box-color i").hide();
  $("#check_bg_color_project_add_" + id).show();
  $(".example-new-card").css('background-color', '#' + color);
  
}
function activeColorMini(id) {
  const color = $("#bg_color_project_mini_" + id).val();
  $(".box-color i").hide();
  $("#check_bg_color_project_add_" + id).show();
  $(".example-new-card").css('background-color', '#' + color);
  
}

$("form#edit_project").submit(function(e) {
  e.preventDefault();    
    var formData = new FormData(this);

    $.ajax({
        url: "aj.php",
        type: 'POST',
        data: formData,
        success: function (data) {
          $("#show-resault-add_project").html(data);
          $("#myModal2").modal('hide');
          window.location = "tasks.php?op=chart&prjid="+ $("#prjid").val();
        },
        cache: false,
        contentType: false,
        processData: false
    });
});

$("form#project").submit(function(e) {
    e.preventDefault();    
    var formData = new FormData(this);

    $.ajax({
        url: "aj.php",
        type: 'POST',
        data: formData,
        success: function (data) {
          $("#show-resault-add_project").html(data);
          $("#show_add_project").modal('hide');
          window.location = "index.php";
          // alert(data)
        },
        cache: false,
        contentType: false,
        processData: false
    });
});

function editIssueForm(iid, tskid) {
    $("#resault-edit_issue").html('<img src="img/wait.gif">');

    var fd = new FormData();

    fd.append('op'            , "edit_issue_form");
    fd.append('iid'           , iid);
    fd.append('ifile1'        , ($('#ifile1').length == 0 ? '' : $('#ifile1')[0].files[0]));
    fd.append('ifile2'        , ($('#ifile2').length == 0 ? '' : $('#ifile2')[0].files[0]));
    fd.append('ifile3'        , ($('#ifile3').length == 0 ? '' : $('#ifile3')[0].files[0]));
    fd.append('ititle'        , $("#ititle").val());
    fd.append('iproirity'     , $("#iproirity").val());
    fd.append('icomplexity'   , $("#icomplexity").val());
    fd.append('ineeded_time'  , $("#ineeded_time").val());
    fd.append('tyid'          , $("#tyid").val());
    fd.append('prjid'         , $("#prjid").val());
    fd.append('iversion'      , $("#iversion").val());
    fd.append('idesc'         , $("#idesc").val());
    fd.append('ifile1_temp'   , $("#ifile1_temp ").val());
    fd.append('delpic1'       , $("#delpic1").is(":checked") == 'true' ? '1' : '0');
    fd.append('ifile2_temp'   , $("#ifile2_temp ").val());
    fd.append('delpic2'       , $("#delpic2").is(":checked") == 'true' ? '1' : '0');
    fd.append('ifile3_temp'   , $("#ifile3_temp").val());
    fd.append('delpic3'       , $("#delpic3").is(":checked") == 'true' ? '1' : '0');
    fd.append('iwho_fullname' , $("#iwho_fullname").val());
    fd.append('iwho_email'    , $("#iwho_email").val());
    fd.append('iwho_tel'      , $("#iwho_tel").val());
    fd.append('iarchive'      , $("#iarchive").val());
    fd.append('idone_date'    , $("#idone_date").val());
    fd.append('idone_version' , $("#idone_version").val());
    fd.append('idone'         , $("input[name='idone']:checked").val());


    $.ajax({
      url: "aj.php",
      type: "POST",
      data: fd,
      processData: false,
      contentType: false,
      success: function(data,status) {
        $("#resault-edit_issue").html(data);
        $("#show_chart_issue").modal('hide');
        IssueInfo(iid, tskid);
        IssueList(tskid);
        // location.reload();
      },
      error: function() {$("#resault-edit_issue").html("problem in ajax")}
    });
};

function checkDonBox() {
  if ($("input[name='idone']:checked").val() == 1) {
    $("#done_issue_box").show();
  }
  else {
    $("#done_issue_box").hide();
  }
}

function editTaskForm(tskid, aid) {
    $("#resault-edit_task").html('<img src="img/wait.gif">');
    console.log($("input[name='tskdone']:checked").val());
    $.ajax({
      url: "aj.php",
      type: "POST",
      data: {op:"edit_task", 
              tskid         : tskid, 
              tsktitle      : $("#tsktitle").val(),
              tskdesc       : $("#tskdesc").val(),
              tskdone       : $("input[name='tskdone']:checked").val(),
              tskdone_date  : $("#tskdone_date").val(),
              admins        : $("#admins").val(),
              prjid         : $("#prjid").val(),
              admin_id      : aid
            },
      success: function(data,status) {
        $("#resault-edit_task").html(data);
        $("#show_edit_task").modal();
        location.reload();
        // $("#show_chart_issue").modal('hide');
      },
      error: function() {$("#resault-edit_task").html("problem in ajax")}
    });
};

function showUsers(tskid) {
  // console.log($(".popover.fade.bs-popover-bottom.show"));
  // if ($(".popover.fade.bs-popover-bottom.show").length > 0)
  // {
  //      $("#popover-show-user").popover('hide');
  // }
  // else {
    $.ajax({
          url: "aj.php",
          type: 'POST',
          data: {op:"show_user_task", task_id: tskid},
          dataType: 'html',
          success: function(answer) {
              $("#popover-show-user").popover({
                  container: 'body',
                  html: true,
                  content: answer
              });
              // $("#popover-show-user").popover('show')
          },
      })    
  }
// }

function setAdmin(userId, tskid) {
  $.ajax({
        url: "aj.php",
        type: 'POST',
        data: {op:"set_admin_task", taskid: tskid, admin_id: userId},
        success: function(data) {
            $("#show-resault-set_admin").html(data);
        },
    })  
}

function hideShowUser() {
  $("#popover-show-user").popover('hide')
}
function activeColorProject(id) {
  const color = $("#bg_color_project" + id).val();
  $(".box-color i").hide();
  $("#check_bg_color_project" + id).show();
  $("#wrapper").css('background-image', 'linear-gradient(#' + color + ', #' + color +')');
  
}