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
	<script src="/assets/flatui/js/jquery-1.8.3.min.js"></script>
    <script src="/assets/flatui/js/jquery-ui-1.10.3.custom.min.js"></script>
    <script src="/assets/flatui/js/jquery.ui.touch-punch.min.js"></script>
    <script src="/assets/flatui/js/bootstrap.min.js"></script>
    <script src="/assets/flatui/js/bootstrap-select.js"></script>
    <script src="/assets/flatui/js/bootstrap-switch.js"></script>
    <script src="/assets/flatui/js/flatui-checkbox.js"></script>
    <script src="/assets/flatui/js/flatui-radio.js"></script>
    <script src="/assets/flatui/js/jquery.tagsinput.js"></script>
    <script src="/assets/flatui/js/jquery.placeholder.js"></script>
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
		
	});
</script>
</body>
</html>