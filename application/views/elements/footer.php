</div><!--end innermaincontent-->
</div><!--end maincontent-->
</main>
<footer class="page-footer" style="clear:both;">
    <div class="container">
         <div id="foot_wrap" class="row">
            <div class="col s6">
                <p class="left">&copy; <?php echo date('Y'); ?> DivLov</p>
            </div>
            <div class="col s6">
                    <ul class="right inline">
                        <li><a href="/index.php/sup/legal">legal</a> | </li>
                        <li><a href="/index.php/sup/contact">contact us</a> | </li>
                        <li><a href="/index.php/sup/about">about us</a> | </li>
                        <li><a href="/index.php/sup/tips">tips</a></li>
                    </ul>
            </div>
        </div>
    </div>
</footer>
</div><!--end class container-->
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="/assets/bower_components/materialize/dist/js/materialize.min.js"></script>
<script src="/assets/js/response.js"></script>
<script src="/assets/js/favorite.js"></script>

<script>

    $('select').material_select();
    $(function(){
		$("div.user_image").hover(function(){
			$(this).children('div.dissapear').switchClass('dissapear','show_inline');
		},function(){
			$(this).children('div.show_inline').switchClass('show_inline','dissapear');
		})
    });
	/*$(function() {
		$('.banner').unslider();
	});*/
	/*$(function() {
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
	*/
</script>

</body>
</html>
