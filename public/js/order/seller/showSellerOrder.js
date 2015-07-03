/**
 * Created by nlouie on 6/16/15.
 */

$(document).ready(function() {
    // Date time picker
    // http://xdsoft.net/jqplugins/datetimepicker/
   $('#datetimepicker').datetimepicker({
       format: 'm/d/Y H:i',
       minDate:'-1970/01/01',//yesterday is minimum date(for today use 0 or -1970/01/01)
       //maxDate:'+1970/01/02'//tommorow is maximum date calendar
       minTime: 0,
       //mask:true, // '9999/19/39 29:59' - digit is the maximum possible for a cell
       lang: 'en',
       step: 30
   });
});
