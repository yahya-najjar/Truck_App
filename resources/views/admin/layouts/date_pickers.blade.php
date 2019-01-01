<!-- ============================================================== -->
<!-- Plugins for this page -->
<!-- ============================================================== -->
<!-- Plugin JavaScript -->
<script src="{{asset('/assets/admin/plugins/moment/moment.js')}}"></script>
<!-- Clock Plugin JavaScript -->
<!-- <script src="{{asset('/assets/admin/plugins/clockpicker/dist/jquery-clockpicker.min.js')}}"></script> -->
<!-- Date Picker Plugin JavaScript -->
<script src="{{asset('/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
<!-- Date range Plugin JavaScript -->
<!-- <script src="{{asset('/assets/admin/plugins/timepicker/bootstrap-timepicker.min.js')}}"></script> -->
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<script src="{{asset('/assets/admin/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>

<!-- <script src="{{asset('/assets/admin/plugins/bootstrap-daterangepicker/daterangepicker.js')}}"></script> -->
<script>
    $('#date-format').bootstrapMaterialDatePicker({ format: 'dddd DD MMMM YYYY - HH:mm' });
    
    // MAterial Date picker
    $('#mdate').bootstrapMaterialDatePicker({weekStart: 0, time: false});
    $('.mdate').bootstrapMaterialDatePicker({weekStart: 0, time: false});
    $('#pdate').bootstrapMaterialDatePicker({weekStart: 0, time: false});
    $('#timepicker').bootstrapMaterialDatePicker({format: 'HH:mm', time: true, date: false , interval: 10});
    $('#timepickerTo').bootstrapMaterialDatePicker({format: 'HH:mm', time: true, date: false});
    $('#placement').bootstrapMaterialDatePicker({format: 'DD-MM-YYYY HH:mm' , minDate: new Date()}); //dddd DD MMMM YYYY - HH:mm

    $('#min-date').bootstrapMaterialDatePicker({format: 'DD/MM/YYYY HH:mm', minDate: new Date()});
    $('.pendingPlacement').bootstrapMaterialDatePicker({format: 'YYYY-MM-DD HH:mm' , minDate: new Date()}); //dddd DD MMMM YYYY - HH:mm

    // Date Picker
    jQuery('.mydatepicker, #datepicker').datepicker();
    jQuery('#datepicker-autoclose').datepicker({
        autoclose: true,
        todayHighlight: true
    });
    jQuery('#date-range').datepicker({
        toggleActive: true
    });
    jQuery('#datepicker-inline').datepicker({
        todayHighlight: true
    });
    // Daterange picker
    // $('.input-daterange-datepicker').daterangepicker({
    //     buttonClasses: ['btn', 'btn-sm'],
    //     applyClass: 'btn-danger',
    //     cancelClass: 'btn-inverse'
    // });
    // $('.input-daterange-timepicker').daterangepicker({
    //     timePicker: true,
    //     format: 'MM/DD/YYYY h:mm A',
    //     timePickerIncrement: 30,
    //     timePicker12Hour: true,
    //     timePickerSeconds: false,
    //     buttonClasses: ['btn', 'btn-sm'],
    //     applyClass: 'btn-danger',
    //     cancelClass: 'btn-inverse'
    // });
    // $('.input-limit-datepicker').daterangepicker({
    //     format: 'MM/DD/YYYY',
    //     minDate: '06/01/2015',
    //     maxDate: '06/30/2015',
    //     buttonClasses: ['btn', 'btn-sm'],
    //     applyClass: 'btn-danger',
    //     cancelClass: 'btn-inverse',
    //     dateLimit: {
    //         days: 6
    //     }
    // });


</script>