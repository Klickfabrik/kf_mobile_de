var service,
    resultContainer,
    form,
    objects,
    offset,
    countObj,
    loadingText = "Loading...",
    init;

jQuery(document).ready(function ($) {

    service = {
        init: function(){
            form = $('#ajaxselectlist-form');
            resultContainer = $('#ajaxCallResult');
            objects = $('[name="objects"]');
            offset = $('[name="offset"]');
            countObj = $('.count_wrap .count,button .count');

            if(form.hasClass("simple")){
                service.sortByJson(form);
            }

            form.on('change', function (ev) {
                ev.preventDefault();
                service.changeCount(loadingText);
                service.getCount($(this));
            });
            form.on('submit', function (ev) {
                ev.preventDefault();

                resultContainer.html(loadingText);
                service.getVehicles($(this),false,0);
                if( form.hasClass("simple") || form.hasClass("target")){
                    setTimeout(function(){
                        window.location = form.attr("action");
                    },200);
                }
            });
        },
        getVehicles: function (data,append,offsetPos) {
            objects.val(1);
            offset.val(offsetPos);
            resultContainer.find(".wrap_next .btn").addClass("disabled").text(loadingText);

            $.ajax({
                url: "/",
                cache: false,
                data: data.serialize(),
                success: function (result) {
                    resultContainer.find(".wrap_next").fadeOut();
                    if(append == 1){
                        resultContainer.append(result);
                    } else {
                        resultContainer.html(result).fadeIn('fast');
                    }
                },
                error: function (jqXHR, textStatus, errorThrow) {
                    resultContainer.html('Ajax request - ' + textStatus + ': ' + errorThrow).fadeIn('fast');
                }
            });
        },
        getCount: function (data) {
            objects.val(0);

            $.ajax({
                url: "/",
                cache: false,
                data: data.serialize(),
                success: function (result) {
                    let json = $.parseJSON(result);
                    service.changeCount(json.count);
                },
                error: function (jqXHR, textStatus, errorThrow) {
                    resultContainer.html('Ajax request - ' + textStatus + ': ' + errorThrow).fadeIn('fast');
                }
            });
        },
        changeCount(input){
            countObj.html(input);
        },
        getLastSearch(){
            var cookieName = "KfMobileDesearch",
            _rawData = readCookie(cookieName) !== "" ? decodeURIComponent(readCookie(cookieName)) : {};

            return $.parseJSON(_rawData);
        },
        setCookieValues(data){
            var input, value;

            $.each(data,function(k,v){
                if(typeof v === "object"){
                    $.each(v,function(subK,subV) {
                        if(subV !== ""){
                            value = service.encode_utf8(subV);
                            input = form.find('[name*="_search['+k+']['+subK+']"]');

                            service.setValue(input,value);
                        }
                    });
                } else {
                    if(v !== ""){
                        value = v;
                        input = form.find('[name*="_search['+k+']"]');

                        service.setValue(input,value);
                    }
                }
            });
        },
        setValue(input,value) {
            switch(input.attr('type')){
                case "checkbox":
                case "radio":
                    $.each(input,function(){
                        var iThat = $(this);
                        if(iThat.val() === value){
                            iThat.attr("checked");
                        }
                    });
                    break;
                default:
                    input.val(value);
                    break;
            }
        },
        encode_utf8(text) {
            var entities = [
                ['amp', '&'],
                ['apos', '\''],
                ['#x27', '\''],
                ['#x2F', '/'],
                ['#39', '\''],
                ['#47', '/'],
                ['lt', '<'],
                ['gt', '>'],
                ['nbsp', ' '],
                ['quot', '"'],
                ['00eb', 'ë'],
            ];

            for (var i = 0, max = entities.length; i < max; ++i)
                text = text.replace(new RegExp('&'+entities[i][0]+';', 'g'), entities[i][1]);

            return text;
        },
        sortByJson(form){
            if(typeof search_json !== "undefined"){
                let firstField = "make";

                // init
                let field   = '#'+firstField;
                let $make   = $(field);
                service.fillSelectField($make,search_json,'first');

                setTimeout(function(){
                    service.changeByJson(form,field,firstField);
                },100);

                // change
                form.find(field).on('change', function (ev) {
                    service.changeByJson(form,field,firstField);
                });
            }
        },
        changeByJson(form,field,firstField){
            let selected = form.find(field).val();

                // elements
            $.each(search_json[selected], function (sortKey, values) {
                if (sortKey !== firstField) {
                    let curField = $('#'+sortKey);
                    service.fillSelectField(curField,values,'sub');
                }
            });
        },
        fillSelectField(field,data,type){
            let first = field.find('option').eq(0);

            field.html("");
            field.append(first);
            $.each(data,function(k,v){
                let value = "";
                switch(type){
                    case 'first':
                        value = k;
                        break;
                    case 'sub':
                        value = v;
                        break;
                }
                field.append('<option value="'+value+'">'+value+'</option>');
            });
        }
    };

    if(typeof init === "undefined"){
        init = true;
        service.init();

        var lastSearch = service.getLastSearch();
        if(lastSearch != null){
            service.setCookieValues(lastSearch);
        }

        service.getCount(form);
        service.getVehicles(form,0,0);
    }
});