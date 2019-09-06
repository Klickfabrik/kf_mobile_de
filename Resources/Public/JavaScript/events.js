(function( $ ){
    $('body').on('click','.kf_send_mail',function(e){
        e.preventDefault();

        var that = $(this),
            base = $('base').attr("href"),
            url = that.attr("href"),
            param = url.indexOf("?") == -1 ? "?" : "&",
            data = window[that.data("item")],
            powermail = "tx_powermail_pi1",
            urlData = "",
            urlkey,
            urlvalue,
            redirect_url;

        $.each(data,function(key,value){
            urlkey      = powermail + "[" + key + "]=";
            urlvalue    = encodeURIComponent(value) + "&";

            urlData += urlkey + urlvalue
        });

        redirect_url = base + url + param + urlData;
        window.location.href = redirect_url;
    });

})( jQuery );