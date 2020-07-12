$( document ).ready(function() {
    // DOM ready    
    // Test data    
    /*     
    * To test the script you should discomment the function     
    * testLocalStorageData and refresh the page. The function     
    * will load some test data and the loadProfile     
    * will do the changes in the UI     
    *///
    testLocalStorageData();    
    // 
    Load profile if it exits    loadProfile();
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

