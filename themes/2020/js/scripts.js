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

function addTask(prjid, aid) {
    const task_title = $("#modal_new_task").val();
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

function editIssue() {
  $("#resault-edit_issue").html('<img src="img/wait.gif">');

  var x = $("form#edit_issue").serializeArray(); 
  $.each(x, function(i, field) { 
      $("#output").append(field.name + ":" 
              + field.value + " "); 
  }); 
  console.log($("#output"));
  $.ajax({
      url: "aj.php",
      type: "POST",
      data: {op: "edit_issue_form"},
      success: function (data) {
        $("#resault-edit_issue").html(data);
        // $("#show_add_project").modal('hide');
        // window.location = "index.php";
        // alert(data)
      },
      cache: false,
      contentType: false,
      processData: false
  });
}
$(".modal form#edit_issue").submit(function(e) {
  console.log('ok');
    // e.preventDefault();    
    // var formData = new FormData(this);

    // $.ajax({
    //     url: "aj.php",
    //     type: 'POST',
    //     data: formData,
    //     success: function (data) {
    //       $("#show-resault-add_project").html(data);
    //       $("#show_add_project").modal('hide');
    //       window.location = "index.php";
    //       // alert(data)
    //     },
    //     cache: false,
    //     contentType: false,
    //     processData: false
    // });
});

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