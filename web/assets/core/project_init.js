window._project_init = function () {

    return {
        init: function () {

            /** Sol menüyü sayfalara göre aktif eder */
            _kodpit.utils.setPageToLeftSidebar("#left_sidebar_id_olacak");
            /** Sayfada bulunan her formu validate eder. Validate olmasını istemediğimiz forma noValidate class eklemeliyiz */
            _validation.handleValidation();

            console.log("tüm kütüphane initleri burada olmaı");
        }
    }

}();

_project_init.init();
