
window._kodpit = function () {


    var layout = {
        createBreadcrumb: function (breadcrumb, mainSidebar, activeClass) {

            if (!activeClass) {
                activeClass = "active";
            }
            var $mainSidebar = $(mainSidebar);
            var $breadcrumb = $(breadcrumb);
            var ol = $breadcrumb.find("ol.breadcrumb");
            // var li = $mainSidebar.find("li");
            var a = $mainSidebar.find("li.active > a");

            var breadcrumbLi = "";
            var totalIndex = a.length;
            // console.log(totalIndex)
            console.log(a);
            $.each(a, function (i, val) {
                var baseURI = val.baseURI;
                var href = val.href;
                if (href != 'javascript:void(0);' && href != 'javascript:void(0)') {


                    var text = val.innerText;

                    var link = '<a href="' + href + '">' + text + '</a>';

                    var setActive = "";
                    if ((totalIndex - 1) == i) {
                        setActive = activeClass;
                        link = ' <strong>' + link + '</strong>';
                    }
                    breadcrumbLi += '<li class="' + setActive + '">' +
                        link +
                        '</li>';
                }

            });

            $(ol).append(breadcrumbLi);

        }
    }


    var utils = {
        nativeNumberFormat: function (number, digits) {
            console.log(number)
            // number = 1620000
            //

            if (!number) {
                number = 0;
            }
            var option = {}

            if (digits) {
                option.minimumFractionDigits = digits;
            }


            var value = new Intl.NumberFormat('tr-TR', option).format(number);

            if (!value || value == "NaN") {
                value = "";
            }
            return value;
        },
        clearNumberFormat: function (value) {
            if (!value) {
                return "";
            }
            value = value.toString();
            var replaced = value.replace(/\./g, '');
            //TODO hata olurmu parse float?
            return parseFloat(replaced.replace(',', '.'));
        },
        myNumberFormatKeyup: function (input,digits) {
            if (!input) {
                return true;
            }

            var value = input.value;
            if (!value || value == "" || value == null) {
                return true;
            }
            /**
             * içinde . olanları replace yapıyoruz
             */
            var replaced = clearNumberFormat(value);
            /**
             * son karaktere bakıyoruz. eğer virgül olursa virgül sayısına bakıp 2 tane virgül konmasını önleyeceğiz.
             **/
            var lastChar = value[value.length - 1];

            if (lastChar == ",") {
                var virgulSayisi = value.match(/,/g).length;
                if (virgulSayisi > 1) {
                    input.value = value.slice(0, -1);
                }
                return true
            }

            /**
             * Eğer virgül koyulduysa artık nativeFormat yapmıyoruz çünkü bozuyor
             */
            if (value.search(",") !== -1) {
                return true
            }

            var n = nativeNumberFormat(replaced, digits);
            if (!n || n == "NaN") {
                input.value = "";
            } else {

                input.value = n.toLocaleString();
                return n.toLocaleString();
            }
        },
        setPageToLeftSidebar: function (mainSidebar, activeClass) {


            var url = document.location.href;
            var $mainSidebar = $(mainSidebar);

            var li = $mainSidebar.find("li");


            var a = $mainSidebar.find("li a");

            li.removeClass(activeClass);

            $.each(a, function (i, val) {
                var baseURI = val.baseURI;
                var href = val.href;
                var data_page_active = $(val).closest("li").attr("data-page-active");

                if (data_page_active) {

                    var arr = data_page_active.split(",");
                    console.log(arr);
                    for (a in arr) {
                        var isExist = baseURI.search(arr[a]);
                        if (isExist !== -1) {
                            var parentLi = $(val).parents("li");
                            parentLi.addClass(activeClass)
                            parentLi.closest("li").addClass(activeClass);
                        }
                    }

                }

                if (href == baseURI) {

                    var parentLi = $(val).parents("li");
                    parentLi.addClass(activeClass)
                    parentLi.closest("li").addClass(activeClass);

                }


            })
        },
        loadPage: function (url) {
            document.location.href = url;
        }
    }


    var loadingClass = '.loading-wrapper';
    var loadingHtml =
        '<div class="'+loadingClass+'">' +
        '' +
        '</div>';
    var loading = {
        show: function ($el) {
            $(el).append(loadingHtml);
        },
        hide: function ($el) {
            $(el).find(loadingClass).remove();
        }
    }

    /***
     * TOASTS
     */
    function showToast(type, title, msg, options) {
        var defaults = {
            closeButton: true,
            debug: false,
            progressBar: true,
            preventDuplicates: false,
            positionClass: 'toast-top-right',
            onclick: null
        }

        defaults = Object.assign(defaults, options);
        toastr.options = defaults;
        var $toast = toastr[type](msg, title); // Wire up an event handler to a button in the toast, if it exists

        return $toast;
    }
    var toast = {
        // toast: {
            info: function (title, msg, options) {
                showToast("info", title, msg, options);
            },
            error: function (title, msg, options) {
                showToast("error", title, msg, options);
            },
            success: function (title, msg, options) {
                showToast("success", title, msg, options);
            },
            warning: function (title, msg, options) {
                showToast("warning", title, msg, options);
            },
            custom: function (type, title, msg, options) {
                showToast(type, title, msg, options);
            }
        // }

    }

    /***
     * ALETS
     */
    function showAlert(type,title,text,options){

        var defaults = {
            type: type,
            title: title,
            text: text,
            showCancelButton: false,
            confirmButtonColor: "#1d7a76",
            confirmButtonText: "Tamam",
            closeOnConfirm: true

        }

        defaults = Object.assign(defaults, options);


        return new Promise(function (resolve, reject) {
            var $alert = swal(defaults, function (inputValue) {

                if(inputValue){
                    resolve();
                }else{
                    reject();
                }
                // swal("Deleted!", "Your imaginary file has been deleted.", "success");
            });

        })
        // return $alert;

    }
    var alert = {
        // alert: {
            info: function (title, msg, options) {
                return showAlert("info", title, msg, options);
            },
            error: function (title, msg, options) {
                return showAlert("error", title, msg, options);
            },
            success: function (title, msg, options) {
                return showAlert("success", title, msg, options);
            },
            warning: function (title, msg, options) {
                return showAlert("warning", title, msg, options);
            },
            confirm: function (title, msg, options) {
                return showAlert("warning", title, msg, {showCancelButton:true});
            },
            custom: function (type, title, msg, options) {
                return showAlert(type, title, msg, options);
            }
        // }

    }





    //TODO genel değişken olan defaultAjaxOptions birleştirme yapınca eski haline döndürmek gerekebilir
    /***
     * FORM İŞLERMLERİ
     * @type {{sendWithAjax: (function(*=, *=, *=): Promise<any>)}}
     */
    var form = {
        formToJSON: function (element) {
            // var formArray = $(form).serializeArray();
            var formArray = $(element).find("*").serializeArray();

            var returnArray = {};
            for (var i = 0; i < formArray.length; i++) {
                returnArray[formArray[i]['name']] = formArray[i]['value'];
            }
            return returnArray;

        },
        sendWithAjax: function (e, formElement, options) {

            $.extend(defaultAjaxOptions, options);


            var $from;
            if (e) {
                e.preventDefault();
                var target = e.target;
                $from = $(target);
            } else {
                if (formElement) {
                    $from = $(formElement);
                } else {

                    throw "please set form Event or formId"
                }
            }

            var isValid = true;
            try {
                isValid = $from.valid();
            } catch (e) {

            }

            if (!isValid) {
                throw "Form not valid"
            }
            // console.log("sendWithAjax",isValid);

            var $loadingEl = $from.closest("div");

            if(options.loadingElement){
                $loadingEl = $(options.loadingElement);
            }

            return new Promise(function (resolve, reject) {
                // http://jquery.malsup.com/form/#options-object
                $from.ajaxSubmit({
                    beforeSend: function () {
                        _kodpit.loading.show($loadingEl);
                    },
                    success: function (data) {
                        // console.log("data",data)
                        console.log("send with ajax",data);
                        resolve(data);

                        ajaxResponse.success(data);


                    },
                    uploadProgress: function (event, position, total, percentComplete) {
                        console.log("percentComplete", percentComplete)
                    },
                    error: function (err) {
                        reject(err);

                        ajaxResponse.error(err);

                        _kodpit.loading.hide($loadingEl);

                    },
                    complete: function (xhr) {

                        console.log("xhr", xhr)
                        var data = xhr.responseJSON.data;
                        if (!defaultAjaxOptions.autoRedirect || !data.redirect || data.redirect == null) {
                            _kodpit.loading.hide($loadingEl);
                        }


                    }

                });

            })
        }
    }

    var kodpitObj = {};

    kodpitObj.utils = utils;
    kodpitObj.form = form;
    kodpitObj.toast = toast;
    kodpitObj.alert = alert;
    kodpitObj.loading = loading;

    /**
     * Tarih1 - Tarih2
     * tip days gün olarak verir. Boş olursa timestamps verir. years, months, weeks, days, hours, minutes, and seconds alabilir.
     * @param tarih1
     * @param tarih2
     * @param tip
     * @returns {*}
     */
    kodpitObj.dateDiff = function (tarih1, tarih2, tip ) {
        if(!tip){
            tip = "days";
        }
        return moment(tarih1).diff(moment(tarih2), tip);
    }



    /** AJAX İŞLEMLERİ **/
    var defaultAjaxOptions = {
        autoToast: true,
        autoRedirect: true,
    };

    /**
     * Normal ajax ve Form ajaxlar için default success error functions
     * @type {{success: success, error: error}}
     */
    var ajaxResponse = {
        success: function (data) {

            if (defaultAjaxOptions.autoToast && data.msg) {

                if (data.messageType) {
                    _kodpit.toast[data.messageType](data.msg)

                } else {
                    _kodpit.toast.success(data.msg);

                }
            }


            if (defaultAjaxOptions.autoRedirect && data.redirect && data.redirect != null) {
                document.location.href = data.redirect;
            }

        }, error: function (err) {

            if (defaultAjaxOptions.autoToast && err.responseJSON.msg) {
                _kodpit.toast.error(err.responseJSON.msg);
            }
        }
    };

    /***
     * NORMAL AJAX İŞLEMLERİ
     * @param options
     * @returns {jQuery|*}
     */
    kodpitObj.ajax = function (options) {

        defaultAjaxOptions.type = "post";

        $.extend(defaultAjaxOptions, options);

        // options = Object.assign(defaultAjaxOptions,options);
        defaultAjaxOptions.success = function (data) {

            ajaxResponse.success(data);

            if (typeof options.success == 'function') {
                options.success(data);
            }
        }

        defaultAjaxOptions.error = function (err) {

            ajaxResponse.error(err);
            if (typeof options.error == 'function') {
                options.error(err);
            }
        }


        return $.ajax(defaultAjaxOptions)
    }

    return kodpitObj;

}();

var _validation = function () {
    var validators = {};
    return {
        handleValidation: function (form_selector, ajax) {


            if (!form_selector) {
                form_selector = "form";
            }
            var form_count = 0;
            // for more info visit the official plugin documentation:
            // http://docs.jquery.com/Plugins/Validation
            var forms = $(form_selector);

            $.each(forms, function (i, val) {


                var form1 = $(val);


                if (!form1.hasClass('noValidate')) {

                    var error1 = $('.alert-danger', form1);
                    var success1 = $('.alert-success', form1);

                    var successClass = "has-success";
                    var errorClass = "has-danger";

                    var validator = form1.validate({

                        cancelSubmit: true,
                        errorElement: 'span', //default input error message container
                        errorClass: 'form-error-message', // default input error message class
                        focusInvalid: true, // do not focus the last invalid input
                        //:hidden:not([class~=selectized]),:hidden > .selectized, .selectize-control .selectize-input input
                        ignore: ":not(:visible), .no-validate", // validate all fields including form hidden input
                        lang: 'tr',
                        invalidHandler: function (event, validator) { //display error alert on form submit
                            // validator.focusInvalid();
                            console.log("invalid")
                            console.log(event)
                            console.log(validator)
                            success1.hide();
                            error1.show();
                            // App.scrollTo(error1, -200);
                        },
                        errorPlacement: function (error, element) {


                            console.log(error)
                            console.log(element)
                            console.log(element.is(":checked"))

                            if (element.is(':checkbox')) {
                                error.insertAfter(element.closest(".md-checkbox-list, .md-checkbox-inline, .checkbox-list, .checkbox-inline"));
                            } else if (element.is(':radio')) {

                                // if (!element.is(":checked")) {
                                //     if(element.closest("td").length > 0){
                                //         element.tooltip({
                                //             title: "Bu alan zorunludur",
                                //             placement: "right"
                                //         }).tooltip("show")
                                //     }else{
                                error.insertAfter(element.closest(".md-radio-list, .md-radio-inline, .radio-list"));//.radio-inline,
                                // }
                                // }


                            } else if (element.is('.bs-select.validate')) {
                                var bs_div = $('div.bs-select.validate');
                                error.insertAfter(bs_div)
                            } else if (element.is('select.validate.normal_select')) {
                                error.insertAfter(element); // for other inputs, just perform default behavior

                            } else if (element.is('select.validate')) {
                                var container = element.closest('div');
                                var span = container.find('span.select2.select2-container');
                                error.insertAfter(span)
                            } else if (element.is('textarea.inbox-editor.inbox-wysihtml5')) {
                                var container = element.closest('div');
                                var span = container.find('iframe.wysihtml5-sandbox');
                                error.insertAfter(span)
                            } else {

                                if ($(element).closest("div").hasClass("bootstrap-select")) {

                                    error.insertAfter($(element).closest("div")[0]);
                                } else if ($(element).closest("div").hasClass("input-group")) {

                                    error.insertAfter($(element).closest("div")[0]); // for other inputs, just perform default behavior

                                } else if ($(element).hasClass("select2")) {

                                    error.insertAfter($(element).closest("div").find("span.select2.select2-container")); // for other inputs, just perform default behavior

                                } else {
                                    error.insertAfter(element)
                                }
                            }
                        },

                        highlight: function (element) { // hightlight error input
                            // console.log("highlight")
                            // console.log(element)

                            // if(!$(element).is(":visible")){
                            //     _tools.log("görünür değildir");
                            // }

                            $(element).closest('.form-group').addClass(errorClass); // set error class to the control group
                            $(element).closest('.form-group-sm').addClass(errorClass); // set error class to the control group
                            $(element).parents('.inbox-form-group').addClass(errorClass); // set error class to the control group
                            $(element).closest('.form-group').removeClass(successClass); // set error class to the control group
                            $(element).closest('.form-group-sm').removeClass(successClass); // set error class to the control group
                            $(element).parents('.inbox-form-group').removeClass(successClass); // set error class to the control group
                            $('select.validate', form1).change(function () {
                                form1.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
                            });
                        },
                        unhighlight: function (element) { // revert the change done by hightlight

                            // console.log("unhighlight")
                            // console.log(element)
                            $(element).closest('.form-group').removeClass(errorClass); // set error class to the control group
                            $(element).parents('.inbox-form-group').removeClass(errorClass); // set error class to the control group
                            $(element).closest('.form-group').addClass(successClass); // set error class to the control group
                            $(element).parents('.inbox-form-group').addClass(successClass); // set error class to the control group
                            $(element).closest('.form-group').find(".form-error-message").remove();
                        },

                        success: function (label) {
                            // console.log("success")
                            // console.log(label)
                            label.closest('.form-group').removeClass(errorClass); // set success class to the control group
                            label.closest('.form-group').addClass(successClass); // set success class to the control group
                        },


                        submitHandler: function (form) {
                            success1.show();
                            error1.hide();
                            // console.log("submit handler")

                            var onsubmit = $(form).attr("onsubmit");

                            if (onsubmit == null || onsubmit == "") {
                                form.submit();
                            }
                            // console.log(onsubmit)
                            // _tools.submitForm();


                            // if (!ajax) {
                            //
                            //     form.submit()//bu olmazsa ajax yapabiliriz
                            //
                            // } else {
                            //
                            //     // {#bu
                            //     //     fonksiyonu
                            //     //     çalıştırıp
                            //     //     fromu
                            //     //     ajax
                            //     //     ile
                            //     //     gönderebilrisin#
                            //     // }
                            //     ajax_handler(form1);
                            //
                            //
                            // }
                        },


                    });

//            var selector = $('#form_sample_2 .validate');
                    var selector = $('select,input,textarea.validate', form1);


                    var validate_group_l = $('.validate-group').length;


                    if (validate_group_l > 1) {
                        var require_from_group = [1, ".validate-group"]
                    }
                    for (var i = 0; i < selector.length; i++) {
                        // console.log("validate for", $(selector[i]))


                        if (validate_group_l < 2) {
                            if ($(selector[i]).hasClass("validate-group")) {
                                $(selector[i]).rules("add", {
                                    required: true
                                })
                            }
                        }

                        try {
                            $(selector[i]).rules("add", {
                                require_from_group: require_from_group || false,
                                messages: {
                                    // required: 'This field is required',
                                    // minlength: jQuery.validator.format('En az {0} karakter girmelisiniz'),
                                    // maxlength: jQuery.validator.format('En fazla {0} karakter girmelisiniz'),
                                    // email: 'Lütfen geçerli email giriniz.',
                                    // url: 'Lütfen geçerli bir url giriniz',
                                    // require_from_group: jQuery.validator.format('Lütfen en az {0} alanı doldurunuz')
                                }
                            });
                        } catch (e) {

                            console.log("validate hata", $(selector[i]))
                            console.log(e)
                        }

                    }


                    var form_id = form1.attr("id");
                    if (!form_id) {
                        form_id = form_count;
                    }
                    validators[form_id] = validator;
                    form_count++;
                }


            });


            // $('.connect-validate').on("change",function () {
            //     var te = $(this).attr("target-element");
            //     prepareNoValidate($(te),true);
            //     prepareNoValidate($(this),false);
            // });

        },
        getValidator: function (form_id) {
            if (!form_id) {
                return validators;
            }
            return validators[form_id];

        }
    }


}();
var _datatable = function () {

// buttons: [
    //     {
    //         extend: 'colvis',
    //         text: "Kolonlar",
    //         colums: [4]
    //     },
    //     {extend: 'copy'},
    //     {extend: 'csv'},
    //     {extend: 'excel', title: 'ExampleFile'},
    //     {extend: 'pdf', title: 'ExampleFile'},
    //
    //     {
    //         extend: 'print',
    //         customize: function (win) {
    //             $(win.document.body).addClass('white-bg');
    //             $(win.document.body).css('font-size', '10px');
    //
    //             $(win.document.body).find('table')
    //                 .addClass('compact')
    //                 .css('font-size', 'inherit');
    //         }
    //     }
    // ],

    function getOptions() {
        return {
            "lengthMenu": [[5,10, 25, 50, -1], [5,10, 25, 50, "Hepsi"]],
            pageLength: 25,
            // responsive: true,
            dom: '<"html5buttons"B>lTfgtr<"col-md-6"i><"col-md-6"p>"',

            button: {
                colvis: {
                    extend: 'colvis',
                    text: "Kolonlar",
                },
                copy: {extend: 'copy'},
                csv: {extend: 'csv'},
                excel: {extend: 'excel', title: 'ExampleFile'},
                pdf: {extend: 'pdf', title: 'ExampleFile'},

                print: {
                    extend: 'print',
                    customize: function (win) {
                        $(win.document.body).addClass('white-bg');
                        $(win.document.body).css('font-size', '10px');

                        $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                    }
                }
            }
        }
    }


    var options = getOptions();

    return {

        options: options,
        initDataTable: function (selector = ".dataTable") {

            var buttons = options.button;
            // console.log(buttons)
            // console.log(options)
            var buttonArray = [];
            for (var b in buttons) {
                var button = buttons[b];
                buttonArray.push(button);
            }
            options.buttons = buttonArray;


            var datatable = $(selector).DataTable(_datatable.options);
            this.resetOptions();
            return datatable;
        },
        resetOptions: function () {
            _datatable.options = getOptions();
        }
    }

}();



/**
 * sg datatable için
 */
function __tableFromSettings(settings) {
    return new $.fn.dataTable.Api(settings);
}


