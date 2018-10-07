<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->
<script src="{{asset('/assets/admin/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap popper Core JavaScript -->
<script src="{{asset('/assets/admin/plugins/bootstrap/js/popper.min.js')}}"></script>
<script src="{{asset('/assets/admin/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
<!-- slimscrollbar scrollbar JavaScript -->
<script src="{{asset('/assets/admin/js/perfect-scrollbar.jquery.min.js')}}"></script>
<!--Wave Effects -->
<script src="{{asset('/assets/admin/js/waves.js')}}"></script>
<!--Menu sidebar -->
<script src="{{asset('/assets/admin/js/sidebarmenu.js')}}"></script>
<!--Custom JavaScript -->
<script src="{{asset('/assets/admin/js/custom.min.js')}}"></script>
<!-- ============================================================== -->
<!-- This page plugins -->
<!-- ============================================================== -->
<!--sparkline JavaScript -->
<script src="{{asset('/assets/admin/plugins/sparkline/jquery.sparkline.min.js')}}"></script>
<!--c3 JavaScript -->
<script src="{{asset('/assets/admin/plugins/d3/d3.min.js')}}"></script>
<script src="{{asset('/assets/admin/plugins/c3-master/c3.min.js')}}"></script>
<!-- Popup message jquery -->
<script src="{{asset('/assets/admin/plugins/toast-master/js/jquery.toast.js')}}"></script>

<!-- Sweet-Alert  -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<!-- Plugin JavaScript -->
<script src="{{asset('/assets/admin/plugins/moment/moment.js')}}"></script>
<script src="{{asset('/assets/admin/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>

<script>

    $('#date-format').bootstrapMaterialDatePicker({ format: 'dddd DD MMMM YYYY - HH:mm' });

    $('[data-delete]').click(function (e) {
        e.preventDefault();

        swal({
            title: "Are You Sure?",
            text: "If you deleted this item you can't restore it lately !",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    $(this).parent().find('> #delete').submit();
                } else {
                    swal("Canceled!");
                }
            });

    });

    $('[data-editable]').click(function () {

        $.ajax({
            type: 'POST',
            url: $(this).data('action'),
            context: this,
            data: {
                '_token': '{{ csrf_token() }}'
            },
            success: function (data) {
                console.log(data);
                var message = '';
                if (data.status) {
                    if (data.type == 'visible') {
                        $(this).find('i').removeClass('mdi-eye').addClass('mdi-eye-off');
                        message = 'Item Marked as Visible !';
                    } else if (data.type == 'featured') {
                        $(this).find('i').removeClass('mdi-star').addClass('mdi-star-off');
                        message = 'تم وضع العنصر كمميز بنجاح!';
                    } else if (data.type == 'new') {
                        message = 'تم وضع العنصر ضمن قائمة جديدنا بنجاح!';
                    }

                } else {
                    if (data.type == 'visible') {
                        $(this).find('i').removeClass('mdi-eye-off').addClass('mdi-eye');
                        message = 'Item Marked as Invisible !';
                    } else if (data.type == 'featured') {
                        $(this).find('i').removeClass('mdi-star-off').addClass('mdi-star');
                        message = 'تم إلغاء تمييز العنصر بنجاح!';
                    } else if (data.type == 'new') {
                        message = 'تم إزالة العنصر من قائمة جديدنا بنجاح!';
                    }

                }

                swal(message, '', "success");
            }
        })
    });

    $('[data-logout]').click(function (e) {
        e.preventDefault();
        swal({
            title: "Are You Sure",
            text: "We hope to See you Soon",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    $(this).parent().find('> form').submit();
                } else {
                    swal("Canceled!");
                }
            });
    })
</script>

<script src="{{asset('/assets/plugins/switchery/dist/switchery.min.js')}}"></script>
    <script src="{{asset('/assets/plugins/select2/dist/js/select2.full.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/assets/plugins/bootstrap-select/bootstrap-select.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js')}}"></script>
    <script src="{{asset('/assets/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js')}}" type="text/javascript"></script>
    <script type="text/javascript" src="{{asset('/assets/plugins/multiselect/js/jquery.multi-select.js')}}"></script>
    <script>
    jQuery(document).ready(function() {
        // Switchery
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        $('.js-switch').each(function() {
            new Switchery($(this)[0], $(this).data());
        });
        // For select 2
        $(".select2").select2();
        $('.selectpicker').selectpicker();
        //Bootstrap-TouchSpin
        $(".vertical-spin").TouchSpin({
            verticalbuttons: true,
            verticalupclass: 'ti-plus',
            verticaldownclass: 'ti-minus'
        });
        var vspinTrue = $(".vertical-spin").TouchSpin({
            verticalbuttons: true
        });
        if (vspinTrue) {
            $('.vertical-spin').prev('.bootstrap-touchspin-prefix').remove();
        }
        $("input[name='tch1']").TouchSpin({
            min: 0,
            max: 100,
            step: 0.1,
            decimals: 2,
            boostat: 5,
            maxboostedstep: 10,
            postfix: '%'
        });
        $("input[name='tch2']").TouchSpin({
            min: -1000000000,
            max: 1000000000,
            stepinterval: 50,
            maxboostedstep: 10000000,
            prefix: '$'
        });
        $("input[name='tch3']").TouchSpin();
        $("input[name='tch3_22']").TouchSpin({
            initval: 40
        });
        $("input[name='tch5']").TouchSpin({
            prefix: "pre",
            postfix: "post"
        });
        // For multiselect
        $('#pre-selected-options').multiSelect();
        $('#optgroup').multiSelect({
            selectableOptgroup: true
        });
        $('#public-methods').multiSelect();
        $('#select-all').click(function() {
            $('#public-methods').multiSelect('select_all');
            return false;
        });
        $('#deselect-all').click(function() {
            $('#public-methods').multiSelect('deselect_all');
            return false;
        });
        $('#refresh').on('click', function() {
            $('#public-methods').multiSelect('refresh');
            return false;
        });
        $('#add-option').on('click', function() {
            $('#public-methods').multiSelect('addOption', {
                value: 42,
                text: 'test 42',
                index: 0
            });
            return false;
        });
        $(".ajax").select2({
            ajax: {
                url: "https://api.github.com/search/repositories",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term, // search term
                        page: params.page
                    };
                },
                processResults: function(data, params) {
                    // parse the results into the format expected by Select2
                    // since we are using custom formatting functions we do not need to
                    // alter the remote JSON data, except to indicate that infinite
                    // scrolling can be used
                    params.page = params.page || 1;
                    return {
                        results: data.items,
                        pagination: {
                            more: (params.page * 30) < data.total_count
                        }
                    };
                },
                cache: true
            },
            escapeMarkup: function(markup) {
                return markup;
            }, // let our custom formatter work
            minimumInputLength: 1,
            templateResult: formatRepo, // omitted for brevity, see the source of this page
            templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
        });
    });
    </script>
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="{{asset('/assets/plugins/styleswitcher/jQuery.style.switcher.js')}}"></script>
    <script src="{{asset('/assets/plugins/dropify/dist/js/dropify.min.js')}}"></script>
    <script>



        $(document).ready(function() {
        // Basic
        $('.dropify').dropify();

        // Translated
        $('.dropify-fr').dropify({
            messages: {
                default: 'Glissez-déposez un fichier ici ou cliquez',
                replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                remove: 'Supprimer',
                error: 'Désolé, le fichier trop volumineux'
            }
        });

        // Used events
        var drEvent = $('#input-file-events').dropify();

        drEvent.on('dropify.beforeClear', function(event, element) {
            return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
        });

        drEvent.on('dropify.afterClear', function(event, element) {
            alert('File deleted');
        });

        drEvent.on('dropify.errors', function(event, element) {
            console.log('Has Errors');
        });

        var drDestroy = $('#input-file-to-destroy').dropify();
        drDestroy = drDestroy.data('dropify')
        $('#toggleDropify').on('click', function(e) {
            e.preventDefault();
            if (drDestroy.isDropified()) {
                drDestroy.destroy();
            } else {
                drDestroy.init();
            }
        })
    });

    </script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>

<!-- <script type="text/javascript" src="../js/jquery-3.3.1.min.js"></script> -->