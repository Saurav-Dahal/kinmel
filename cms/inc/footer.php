<?php
    if( getCurrentPage() != 'index' ){
?>
    <!-- jQuery -->
    <script src="<?php echo JS_URL; ?>jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?php echo JS_URL; ?>bootstrap.min.js"></script>

    <!-- NProgress -->
    <script src="<?php echo JS_URL; ?>nprogress.js"></script>
    
    <!-- Custom Theme Scripts -->
    <script src="<?php echo JS_URL; ?>custom.min.js"></script>
     
     <!-- Data Table Scripts -->
    <script src="<?php echo JS_URL; ?>jquery.dataTables.min.js"></script>

    <script>
    	
           $('.table').DataTable();
           
    </script>
<?php
}
?>
</body>
</html>