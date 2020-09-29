</body>
<footer>
<!--   Core JS   -->
<!--jquery-->
<script src="./<?php echo(APP_PLUGIN)?>jquery/jquery.min.js" type="text/javascript"></script>

<!--datatable-->
<script src="./<?php echo(APP_PLUGIN)?>DataTables/datatables.js"></script>
<script src="./<?php echo(APP_PLUGIN)?>DataTables/dataTables.bootstrap4.min.js"></script>
<script src="./<?php echo(APP_PLUGIN)?>DataTables/dataTables.responsive.min.js"></script>
<script src="./<?php echo(APP_PLUGIN)?>DataTables/responsive.bootstrap4.min.js"></script>

<!--bootstrap-->
<script src="./<?php echo(APP_PLUGIN)?>bootstrap/popper.min.js" type="text/javascript"></script>
<script src="./<?php echo(APP_PLUGIN)?>bootstrap/bootstrap.js" type="text/javascript"></script>

<!--notificaciones-->
<script src="./<?php echo(APP_PLUGIN)?>ohsnap.js" type="text/javascript"></script>

<!--file-boostrap-->
<script src="./<?php echo(APP_PLUGIN)?>bootstrap/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="./<?php echo(APP_PLUGIN)?>file-boostrap/js/plugins/piexif.js" type="text/javascript"></script>
<script src="./<?php echo(APP_PLUGIN)?>file-boostrap/js/plugins/sortable.js" type="text/javascript"></script>
<script src="./<?php echo(APP_PLUGIN)?>file-boostrap/js/fileinput.js" type="text/javascript"></script>
<script src="./<?php echo(APP_PLUGIN)?>locales/es.js" type="text/javascript"></script>
<script src="./<?php echo(APP_PLUGIN)?>file-boostrap/themes/fas/theme.js" type="text/javascript"></script>
<script src="./<?php echo(APP_PLUGIN)?>file-boostrap/themes/explorer-fas/theme.js" type="text/javascript"></script>

<!--datetimepickern-->
<script src="./<?php echo(APP_PLUGIN)?>moment.min.js"></script>
<script src="./<?php echo(APP_PLUGIN)?>bootstrap-datetimepicker.js" type="text/javascript"></script>

<!--toggle-->
<script src="./<?php echo(APP_PLUGIN)?>toggle/bootstrap4-toggle.min.js"></script>

<!--select 2-->
<script src="./<?php echo(APP_PLUGIN)?>select2/select2.full.js"></script>

<!--Input-Spinner-->
<!--<script src="./<?php //echo(APP_PLUGIN)?>Input-Spinner-Plugin-Bootstrap-4/bootstrap-input-spinner.js"></script>-->

<!-- Archivos necesarios de la vista -->
<script src="./view/assets/js/script.js" type="text/javascript"></script>

<!-- Archivos necesarios de la vista -->
<?php if(isset($c)){  ?>
    <script src="./view/html/<?php echo $c."/".$p.".js"; ?>?v=<?php echo(rand()); ?>"></script>
<?php } ?>
</footer>

</html>
