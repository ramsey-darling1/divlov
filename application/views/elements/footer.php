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

<script src="/assets/js/jquery.ui/js/jquery-ui-1.10.0.custom.js"></script>
	
<script src="/assets/js/response.js"></script>
<script src="/assets/js/favorite.js"></script>

<script>
    
	/*$(function() {
		$('.banner').unslider();
	});*/
	$(function() {
		$( "#accordion" ).accordion();
	});
	$(function() {
		$( ".dialog" ).dialog({
		  autoOpen: false,	
		  height: 440,
		  width: 500,
		  modal: true
		});
		$( "#opener" ).click(function() {
		    $( ".dialog" ).dialog( "open" );
		});
	});
	$(function(){
		$("div.user_image").hover(function(){
			$(this).children('div.dissapear').switchClass('dissapear','show_inline');
		},function(){
			$(this).children('div.show_inline').switchClass('show_inline','dissapear');
		})
	});
	
	
</script>

<script>

  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-49094910-1', 'divlov.com');
  ga('send', 'pageview');

</script>

</body>
</html>