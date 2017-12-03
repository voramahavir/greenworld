</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="<?php echo base_url('assets/theme/bower_components/jquery/dist/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/custom/js/jquery.serializeObject.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/custom/js/bootbox.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/custom/js/date.js'); ?>"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url('assets/theme/bower_components/jquery-ui/jquery-ui.min.js'); ?>"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url('assets/theme/bower_components/bootstrap/dist/js/bootstrap.min.js'); ?>"></script>
<!-- Morris.js charts -->
<!-- <script src="<?php // echo base_url('assets/theme/bower_components/raphael/raphael.min.js'); ?>"></script>
<script src="<?php // echo base_url('assets/theme/bower_components/morris.js/morris.min.js'); ?>"></script> -->
<!-- Sparkline -->
<script src="<?php echo base_url('assets/theme/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js'); ?>"></script>
<!-- jvectormap -->
<script src="<?php echo base_url('assets/theme/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/theme/plugins/jvectormap/jquery-jvectormap-world-mill-en.js'); ?>"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo base_url('assets/theme/bower_components/jquery-knob/dist/jquery.knob.min.js'); ?>"></script>
<!-- daterangepicker -->
<script src="<?php echo base_url('assets/theme/bower_components/moment/min/moment.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/theme/bower_components/bootstrap-daterangepicker/daterangepicker.js'); ?>"></script>
<!-- datepicker -->
<script src="<?php echo base_url('assets/theme/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js'); ?>"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo base_url('assets/theme/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js'); ?>"></script>
<!-- Slimscroll -->
<script src="<?php echo base_url('assets/theme/bower_components/jquery-slimscroll/jquery.slimscroll.min.js'); ?>"></script>
<!-- FastClick -->
<script src="<?php echo base_url('assets/theme/bower_components/fastclick/lib/fastclick.js'); ?>"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url('assets/theme/dist/js/adminlte.min.js'); ?>"></script>
<script type="text/javascript">
    var base_url = "<?php echo base_url(); ?>";
    var site_url = "<?php echo site_url(); ?>/";
    $("input").keyup(function () {
        var val = $(this).val();
        $(this).val(val.toUpperCase());
    });
</script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="<?php // echo base_url('assets/theme/dist/js/pages/dashboard.js'); ?>"></script> -->
<!-- AdminLTE for demo purposes -->
<!-- <script src="<?php // echo base_url('assets/theme/dist/js/demo.js'); ?>"></script> -->
