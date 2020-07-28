$( document ).ready(function() {
    // DOM ready    
    // Test data    
    /*     
    * To test the script you should discomment the function     
    * testLocalStorageData and refresh the page. The function     
    * will load some test data and the loadProfile     
    * will do the changes in the UI     
    *///
    // testLocalStorageData();    
    // 
    // Load profile if it exits    loadProfile();
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