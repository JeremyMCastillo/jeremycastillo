<?php echo $header; ?>
<h1 class="accent page-title">About Me</h1>
<hr />
<div class="row background-light">
	<div class="col-lg-5">
		<img id="about-image" alt="About Image" src="<?php echo $logo; ?>" />
	</div>
	<div class="col-lg-7">
		<div class="about-name">
                    <h2 class="accent"><?php echo $text_quote; ?></h2>
                    <div class="titles">
                        <?php echo $text_titles; ?>
                    </div>
		</div>
                <br />
		<div class="about-text">
			<?php echo $text_about; ?>
		</div>
	</div>
</div>
<?php echo $footer; ?>