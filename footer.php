<footer>
	<div class="footer-copyright text-center py-3">© 2019 Copyright:
      <a href="">Shehzan Chowdhury</a>
    </div>
</footer>
</body>
<script type="text/javascript">
	$(document).ready(function(){
  $("#demo").on("hide.bs.collapse", function(){
    $(".btn").html('<span class="glyphicon glyphicon-collapse-down"></span> Open');
  });
  $("#demo").on("show.bs.collapse", function(){
    $(".btn").html('<span class="glyphicon glyphicon-collapse-up"></span> Close');
  });
});
	
</script>

</html>