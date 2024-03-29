var service,
  resultContainer,
  form,
  objects,
  autoload,
  offset,
  countObj,
  loadingText = "Loading...",
  init,
  kf_cookie = kf_cookie || new kf_mobile_cookie();

jQuery(document).ready(function ($) {

  service = {
    _init: 0,

    init: function () {
      var $form_autoload = $('[name="autoload"]');

      form = $('#ajaxselectlist-form,#ajaxselectlist-simple');
      resultContainer = $('#ajaxCallResult');
      objects = $('[name="objects"]');
      autoload = $form_autoload.length ? $form_autoload.val() : 0;
      offset = $('[name="offset"]');
      countObj = $('.count_wrap .count,button .count');

      if (form.length > 0) {
        this._init = 1;

        if (form.hasClass("simple")) {
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
          service.getVehicles($(this), false, 0);
          if (form.hasClass("simple") || form.hasClass("target")) {
            setTimeout(function () {
              window.location = form.attr("action");
            }, 200);
          }
        });

        form.on('reset', function (ev) {
          var that = $(this);
          setTimeout(function () {
            service.changeCount(loadingText);
            service.getCount(that);
          }, 100);
        });
      }
    },
    getVehicles: function (data, append, offsetPos) {
      objects.val(1);
      offset.val(offsetPos);
      resultContainer.find(".wrap_next .btn").addClass("disabled").text(loadingText);

      $.ajax({
        url: service.getDomain(form.attr('action')),
        cache: false,
        data: data.serialize(),
        success: function (result) {
          resultContainer.find(".wrap_next").fadeOut();
          if (append == 1) {
            resultContainer.append(result);
          } else {
            resultContainer.html(result).fadeIn('fast');
          }

          kf_cookie.update();
        },
        error: function (jqXHR, textStatus, errorThrow) {
          resultContainer.find(".wrap_next").fadeOut();
          resultContainer.html('Ajax request - ' + textStatus + ': ' + errorThrow).fadeIn('fast');
        }
      });
    },
    getCount: function (data, reset) {
      let _reset = typeof reset !== "undefined" ? 0 : -1;
      objects.val(_reset);
      form.addClass("loading");

      $.ajax({
        url: service.getDomain(form.attr('action')),
        cache: false,
        data: data.serialize(),
        success: function (result) {
          let json = $.parseJSON(result);
          service.changeCount(json.count);
          service.changeTypes(json.form);

          form.removeClass("loading");
        },
        error: function (jqXHR, textStatus, errorThrow) {
          resultContainer.find(".wrap_next").fadeOut();
          resultContainer.html('Ajax request - ' + textStatus + ': ' + errorThrow).fadeIn('fast');
        }
      });

      if (autoload) {
        service.getVehicles(form, false, 0);
      }
    },
    getDomain: function (string) {
      return window.location.origin;
    },
    changeCount: function (input) {
      countObj.html(input);
    },
    changeTypes: function (formObjects) {
      $.each(formObjects, function (inputName, inputValues) {
        let _input = form.find('[name*="' + inputName + '"]');
        let _type = _input[0] ? _input[0].nodeName : null;

        switch (inputName) {
          case "make":
            //case "model":
            break;
          default:
            if (_input.length > 0) {
              switch (_type) {
                case "SELECT":
                  _input.find('option').attr('disabled', 'disabled');
                  _input.find('option[value=""]').removeAttr('disabled');

                  $.each(inputValues, function (pos, val) {
                    _input.find('option[value="' + val + '"]').removeAttr('disabled');
                  });
                  break;
                case "INPUT":
                  switch (inputName) {
                    case "features":
                    case "specifics":
                      _input.attr('disabled', 'disabled');
                      _input.closest('div').find('label').addClass("disabled");

                      let _that = form.find('[name*="' + inputName + '"][value=""]');
                      _that.closest('label').removeClass('disabled');
                      _that.removeAttr('disabled');

                      $.each(inputValues, function (pos, val) {
                        let _that = form.find('[name*="' + inputName + '"][value="' + val + '"]');
                        _that.closest('label').removeClass('disabled');
                        _that.removeAttr('disabled');
                      });
                      break;
                  }
                  break;
              }
            }
            break;
        }
      });
      form.find('select').selectBox('destroy');
      form.find('select').selectBox('create');
    },
    getLastSearch: function () {
      var cookieName = "KfMobileDesearch",
        _rawData = kf_cookie.getCookie(cookieName) !== "" ? decodeURIComponent(kf_cookie.getCookie(cookieName)) : {};

      return $.parseJSON(_rawData);
    },
    setCookieValues: function (data) {
      var input, value;

      $.each(data, function (k, v) {
        if (typeof v === "object") {
          $.each(v, function (subK, subV) {
            if (subV !== "") {
              value = service.encode_utf8(subV);
              input = form.find('[name*="_search[' + k + '][' + subK + ']"]');

              service.setValue(input, value);
            }
          });
        } else {
          if (v !== "") {
            value = v;
            input = form.find('[name*="_search[' + k + ']"]');

            service.setValue(input, value);
          }
        }
      });
    },
    setValue: function (input, value) {
      switch (input.attr('type')) {
        case "checkbox":
        case "radio":
          $.each(input, function () {
            var iThat = $(this);
            if (iThat.val() === value) {
              iThat.attr("checked");
            }
          });
          break;
        default:
          input.val(value);
          break;
      }
    },
    encode_utf8: function (text) {
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
        text = text.replace(new RegExp('&' + entities[i][0] + ';', 'g'), entities[i][1]);

      return text;
    },
    sortByJson: function (form) {
      if (typeof search_json !== "undefined") {
        let firstField = "make";

        // init
        let field = '#' + firstField;
        let $make = $(field);
        service.fillSelectField($make, search_json, 'first');

        setTimeout(function () {
          service.changeByJson(form, field, firstField);
        }, 100);

        // change
        form.find(field).on('change', function (ev) {
          service.changeByJson(form, field, firstField);
        });
      }
    },
    changeByJson: function (form, field, firstField) {
      let selected = form.find(field).val();

      // elements
      $.each(search_json[selected], function (sortKey, values) {
        if (sortKey !== firstField) {
          let curField = $('#' + sortKey);
          service.fillSelectField(curField, values, 'sub');
        }
      });
    },
    fillSelectField: function (field, data, type) {
      let first = field.find('option').eq(0);

      field.html("");
      field.append(first);
      $.each(data, function (k, v) {
        let value = "";
        switch (type) {
          case 'first':
            value = k;
            break;
          case 'sub':
            value = v;
            break;
        }
        field.append('<option value="' + value + '">' + value + '</option>');
      });
    }
  };

  if (typeof init === "undefined") {
    init = true;
    service.init();

    if (service._init) {
      var lastSearch = service.getLastSearch();
      if (lastSearch != null) {
        service.setCookieValues(lastSearch);
      }

      service.getCount(form);
      service.getVehicles(form, 0, 0);
    }
  }
});
