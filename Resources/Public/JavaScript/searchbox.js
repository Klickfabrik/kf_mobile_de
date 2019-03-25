var service,
    resultContainer,
    form,
    objects,
    offset,
    countObj,
    loadingText = "Loading...",
    init,
    kf_cookie = kf_cookie || new kf_mobile_cookie();


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

            form.on('reset', function (ev) {
                service.changeCount(loadingText);
                service.getCount($(this));
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

                    kf_cookie.update();
                },
                error: function (jqXHR, textStatus, errorThrow) {
                    resultContainer.html('Ajax request - ' + textStatus + ': ' + errorThrow).fadeIn('fast');
                }
            });
        },
        getCount: function (data,reset) {
            let _reset = typeof reset !== "undefined" ? 0 : -1;
            objects.val(_reset);
            form.addClass("loading");

            $.ajax({
                url: "/",
                cache: false,
                data: data.serialize(),
                success: function (result) {
                    let json = $.parseJSON(result);
                    service.changeCount(json.count);
                    service.changeTypes(json.form);

                    form.removeClass("loading");
                },
                error: function (jqXHR, textStatus, errorThrow) {
                    resultContainer.html('Ajax request - ' + textStatus + ': ' + errorThrow).fadeIn('fast');
                }
            });
        },
        changeCount(input){
            countObj.html(input);
        },
        changeTypes(formObjects){
            $.each(formObjects,function(inputName,inputValues){
                let _input = form.find('[name*="'+inputName+'"]');
                if(_input.length > 0){
                    let _type = _input[0].nodeName;
                    switch(_type){
                        case "SELECT":
                            _input.find('option').attr('disabled', 'disabled');
                            _input.find('option[value=""]').removeAttr('disabled');

                            $.each(inputValues,function(pos,val){
                                _input.find('option[value="'+val+'"]').removeAttr('disabled');
                            });
                            break;
                        case "INPUT":
                            switch(inputName){
                                case "features":
                                case "specifics":
                                    _input.attr('disabled', 'disabled');
                                    _input.closest('div').find('label').addClass("disabled");

                                    let _that = form.find('[name*="'+inputName+'"][value=""]');
                                    _that.closest('label').removeClass('disabled');
                                    _that.removeAttr('disabled');

                                    $.each(inputValues,function(pos,val){
                                        let _that = form.find('[name*="'+inputName+'"][value="'+val+'"]');
                                        _that.closest('label').removeClass('disabled');
                                        _that.removeAttr('disabled');
                                    });
                                    break;
                            }
                            break;
                    }
                }
            });
            form.find('select').selectBox('destroy');
            form.find('select').selectBox('create');
        },
        getLastSearch(){
            var cookieName = "KfMobileDesearch",
                _rawData = kf_cookie.getCookie(cookieName) !== "" ? decodeURIComponent(kf_cookie.getCookie(cookieName)) : {};

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