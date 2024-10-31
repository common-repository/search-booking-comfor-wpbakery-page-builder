(function ($) {
    "use strict";

    $(document).ready(function () {
        tomiup_bookingcom.ready();
    });


    //Main
    var tomiup_bookingcom = window.$tomiup_bookingcom = {

        ready: function () {
            this.init_datepicker();
        },

        init_datepicker: function () {
            var today = new Date();
            var tomorrow = new Date();

            var $checkin = $('.bcsb-datepicker.checkin');
            var $checkout = $('.bcsb-datepicker.checkout');

            $checkin.datepicker({
                minDate: today,
                maxDate: '+30D',
                showOn: "button",
                buttonText: "<i class='bcsb-icon-calendar'></i>",
                altField: "input[name=checkin_year_month]",
                altFormat: "yy-mm",
                dateFormat: 'd M, y',
                onSelect: function () {
                    var date = $(this).datepicker('getDate');
                    $("input[name=checkin_monthday]").val(date.getDate());
                    date.setDate(date.getDate() + 1);
                    $checkout.datepicker('option', 'minDate', date);
                    setTimeout(function () {
                        $checkout.datepicker('show');
                    }, 100)
                }
            }).on('click', function () {
                $checkin.datepicker('show');
            });

            $checkout.datepicker({
                minDate: tomorrow,
                maxDate: '+30D',
                // showOn: "button",
                // buttonText: "",
                altField: "input[name=checkout_year_month]",
                altFormat: "yy-mm",
                dateFormat: 'd M, y',
                onSelect: function () {
                    var date = $(this).datepicker('getDate');
                    $("input[name=checkout_monthday]").val(date.getDate());
                    date.setDate(date.getDate() - 1);
                    $checkin.datepicker('option', 'maxDate', date);
                }
            }).on('click', function () {
                $checkout.datepicker('show');
            });
        },
    }

})(jQuery);