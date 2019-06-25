var kf_mobile_cookie = (function () {
    var cookie = {
        _init       : 0,
        delay       : 100,
        callback    : 0,
        debug       : 0,
        saveButton  : '[data-action="save"]',
        clearButton : '[data-action="clear"]',
        cookieSplit : "|",
        cookieName  : "kf_mobile_de",
    };

    cookie.run = function(){
        display_function("kf_mobile_cookie init...");

        event_btn();
        displayCookieData();


        // callback
        cookie._init = 1;
        display_function("kf_mobile_cookie ready...");
    };
    cookie.update = function(){
        displayCookieData();
    };
    cookie.getCookie = function(name){
        return readCookie(name);
    };
    cookie.getCallback = function(){
        return cookie.callback_log;
    };


    var event_btn = function(){
        $(document).on('click',cookie.saveButton,function(e){
            var that = $(this),
                _class = "btn-active",
                curData = that.data(),
                uid = String(curData.uid),
                insertData = [],
                cookieData = readCookie(cookie.cookieName);

            if(cookieData !== null){
                insertData = cookieData.split(cookie.cookieSplit);
            }

            // button-state
            if(that.hasClass(_class)){
                // remove data
                if(insertData.indexOf(uid)!==-1)
                    insertData = removeKey(insertData,uid);

                that.removeClass(_class);
            } else {
                // add to data
                if(insertData.indexOf(uid)===-1)
                    insertData.push(uid);

                that.addClass(_class);
            }

            // Update
            displayCookieCount(insertData);

            // write cookie
            cookieData = insertData.join(cookie.cookieSplit);
            createCookie(cookie.cookieName,cookieData,1);
        });

        $(document).on('click',cookie.clearButton,function(){
            // cookie reset
            createCookie(cookie.cookieName,"",1);

            // Update
            displayCookieCount("");

            // Reload
            window.location.reload();
        });
    };


    var removeKey = function(arrayName,key) {
        for( var i = 0; i < arrayName.length; i++){
            if ( arrayName[i] === key) {
                arrayName.splice(i, 1);
            }
        }

        return arrayName;
    };

    var displayCookieData = function(){
        display_function("displayCookieData ...");

        var cookieData = readCookie(cookie.cookieName),
            insertData = [],
            _class = "btn-active";

        if(cookieData !== null){
            insertData = cookieData.split(cookie.cookieSplit);
        }

        displayCookieCount(insertData);

        $('.btn[data-uid]').removeClass(_class);
        $.each(insertData,function(k,v){
            var $btn = $('.btn[data-uid="'+v+'"]');
            $btn.addClass(_class);
        });
    };

    var displayCookieCount = function(insertData){
        display_function("displayCookieCount...");

        var count = 0;
        $.each(insertData,function(k,v){
            if(v != ""){
                count++;
            }
        });

        // write count
        $('[data-count]').text(count);
    };

    var createCookie = function(name, value, days) {
        display_function("createCookie: " + value);
        var expires;

        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toGMTString();
        } else {
            expires = "";
        }

        document.cookie = name + "=" + value + expires + "; path=/";
    };

    var readCookie = function(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    };

    var eraseCookie = function(name) {
        createCookie(name, "", -1);
    };


    // H E L P E R

    // Debug
    var display_function = function(functionname){
        if(cookie.debug){
            var currentdate = new Date(),
                getTime = + currentdate.getHours() + ":"
                    + currentdate.getMinutes() + ":"
                    + currentdate.getSeconds();

            console.info("[" + getTime + "] " + functionname);
        }

        if(cookie.callback){
            cookie.callback_log = {
                time : getTime,
                message : functionname
            };
        }
    };

    return cookie;
});

var kf_cookie = kf_cookie || new kf_mobile_cookie();
$(function(){
    if(kf_cookie._init == 0){
        kf_cookie.debug = 1;
        kf_cookie.run();
    }
});