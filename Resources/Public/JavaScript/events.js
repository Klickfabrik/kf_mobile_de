$(function(){
    $('body').on('click','.kf_send_mail',function(e){
        var that = $(this),
            url = that.attr("href"),
            param = url.indexOf("?") == -1 ? "?" : "&",
            data = window[that.data("item")],
            powermail = "tx_powermail_pi1",
            urlData = "";

        $.each(data,function(key,value){
            urlData += powermail + "[" + key + "]=" + encodeURIComponent(value) + "&"
        });

        url = url + param + urlData;

        window.location.href = url;

        return false;
    })
});