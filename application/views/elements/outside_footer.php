<div class="brick"></div>
</div><!--end innermaincontent-->
</div><!--end maincontent-->
<div id="foot_wrap">
    <div id="foot" class="fit_width link_style1">
	<p class="left">&copy; <?php echo date('Y'); ?> DivLov</p>
	<ul class="right inline">
	    <li><a href="/index.php/sup/legal">legal</a> | </li>
	    <li><a href="/index.php/sup/contact">contact us</a> | </li>
	    <li><a href="/index.php/sup/about">about us</a> | </li>
	    <li><a href="/index.php/sup/tips">tips</a></li>
	</ul>
	<div class="brick"></div>
    </div>
</div>
</div><!--end class container-->
<!--Import jQuery before materialize.js-->
      <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
      <script type="text/javascript" src="/assets/bower_components/materialize/dist/js/materialize.min.js"></script>
	<script src="/assets/js/register.js"></script>
	<script>
	$(document).ready(function(){
		$('#couple_checkbox').click(function(){
			var isChecked = $('#couple_checkbox').is(':checked');
			if(isChecked == true){
				$('#for_couples').slideDown();
			}else{
				$('#for_couples').slideUp();
			}
		});

        $('select').material_select();
		
	});
    </script>
</body>
</html>
