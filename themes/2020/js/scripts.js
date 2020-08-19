$(document).ready(function() {
    $('.editor').richText();
});

    $(document).ready(function () {
      var popoverContent = '<div> \
                                    <select class="form-control mb-1"> \
                                        <option value="eq">Is equal to</option>  \
                                        <option value="ct">Contains</option> \
                                    </select> \
                                    <input type="text" class="form-control"> \
                                </div>';
    
      $('#exampleModalLong').on('shown.bs.modal', function (e) {
        var popover = $('#popover-btn').popover({
          title: '',
          placement: 'bottom',
          html: true,
          content: popoverContent,
          trigger: 'manual'
        });
      });
    
      $('#popover-btn').click(function () {
        $(this).popover('show');
      });
    
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
    data: {op:"edit_task", tskid: id},
    success: function(data,status) {
      $("#show-resault-edit_task").html(data);
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
  $("#check_bg_color_project" + id).show();
  $(".example-new-card").css('background-color', '#' + color);
  
}
function activeColorProject(id) {
  const color = $("#bg_color_project" + id).val();
  $(".box-color i").hide();
  $("#check_bg_color_project" + id).show();
  $("#wrapper").css('background-image', 'linear-gradient(#' + color + ', #' + color +')');
  
}