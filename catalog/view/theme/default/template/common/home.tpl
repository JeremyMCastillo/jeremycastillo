<?php echo $header; ?>
<div id="content">
	<div class="row home background-dark">
		<div class="col-lg-5">
			<div class="row">
				<div class="col-sm-12">
					<h1 class="notice accent">
						Welcome
					</h1>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12 pt-40">
					<h3 class="notice">
						My name is Jeremy Castillo. Let's talk about <span id="talk-subject"><select id="showcase-select" class="showcase-select">
								<?php foreach($showcases as $category_id => $showcase_data) { ?>
                                                                    <option value="<?php echo $category_id; ?>"><?php echo $showcase_data['title']; ?></option>
								<?php } ?>
							</select></span>
					</h3>
				</div>
			</div>
		</div>
		<div class="col-lg-7">
			<div id="console-window">
			</div>
		</div>
	</div>
	<hr />
	<!-- Portfolio section BEGIN -->
	<?php echo $portfolio; ?>
	<!-- Portfolio section END -->
	<hr />
	<!-- Contact section BEGIN -->
	<?php echo $contact; ?>
	<!-- Contact section END -->
</div>

<script type="text/javascript">
	var commands = <?php echo json_encode($showcases); ?>;
	$("#showcase-select").on("change", function(){
            var newLanguage = $(this).val();

            $("#console-window").terminal("changeCommands", commands[newLanguage]["commands"]);
	});
	
	// Document Ready
	$(function(){
		console.log(commands);
		$("#console-window").terminal({
			prompt: "$>",
			editorID: "editor-window",
			commands: commands[$("#showcase-select").val()]["commands"],
			delayms: 50
		});
	});
        
        $("#showcase-select").on('change', function(){
            var selectedCategory = $(this).val();
            $(".portfolio-row").hide();
            $(".portfolio-row").each(function(){
                var categories = $(this).attr("categories").split(',');
                for(var id in categories){
                    if(selectedCategory === categories[id]){
                        $(this).show();
                    }
                }
            });
        });
        
        $(function(){
            $("#showcase-select").trigger("change");
        });
</script>

<?php echo $footer; ?>
