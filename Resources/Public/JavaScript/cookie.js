// Cookies
function createCookie(name, value, days) {
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        var expires = "; expires=" + date.toGMTString();
    }
    else var expires = "";

    document.cookie = name + "=" + value + expires + "; path=/";
}

function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}

function eraseCookie(name) {
    createCookie(name, "", -1);
}

$(function(){
    var saveButton = '[data-action="save"]',
        cookieName = "kf_mobile_de";

    $(document).on('click',saveButton,function(e){
        var that = $(this),
            curData = that.data(),
            uid = String(curData.uid),
            insertData = [],
            split = "|",
            cookieData = readCookie(cookieName);

        if(cookieData !== null){
            insertData = cookieData.split(split);
        }

        if(insertData.indexOf(uid)===-1)
            insertData.push(uid);

        cookieData = insertData.join(split);

        createCookie(cookieName,cookieData,1);
    });
});