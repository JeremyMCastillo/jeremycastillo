<div class="row contact-form background-dark">
    <div class="col-xs-12">
	 <h2 class="accent"><?php echo $heading_title; ?></h2>
         <div class="row">
             <div class="col-sm-12 col-md-5">
                 <p>
                     Have a question?<br /><br />
                     Or just want to chat?<br /><br />
                     Send me a message and I&apos;ll be happy to get back to you as soon as I&apos;m able.
                 </p>
             </div>
             <div class="col-sm-12 col-md-7">
                <form id="contact-form" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                  <fieldset>
                        <div class="form-group required">
                          <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?></label>
                          <div class="col-sm-10">
                                <input type="text" name="name" value="<?php echo $name; ?>" id="input-name" class="form-control" />
                                <?php if ($error_name) { ?>
                                <div class="text-danger"><?php echo $error_name; ?></div>
                                <?php } ?>
                          </div>
                        </div>
                        <div class="form-group required">
                          <label class="col-sm-2 control-label" for="input-email"><?php echo $entry_email; ?></label>
                          <div class="col-sm-10">
                                <input type="text" name="email" value="<?php echo $email; ?>" id="input-email" class="form-control" />
                                <?php if ($error_email) { ?>
                                <div class="text-danger"><?php echo $error_email; ?></div>
                                <?php } ?>
                          </div>
                        </div>
                        <div class="form-group required">
                          <label class="col-sm-2 control-label" for="input-enquiry"><?php echo $entry_enquiry; ?></label>
                          <div class="col-sm-10">
                                <textarea name="enquiry" rows="10" id="input-enquiry" class="form-control"><?php echo $enquiry; ?></textarea>
                                <?php if ($error_enquiry) { ?>
                                <div class="text-danger"><?php echo $error_enquiry; ?></div>
                                <?php } ?>
                          </div>
                        </div>
                        <?php echo $captcha; ?>
                  </fieldset>
                  <div class="buttons">
                        <div class="pull-right">
                          <input class="btn btn-primary" type="button" onclick="submitContact()" value="<?php echo $button_submit; ?>" />
                        </div>
                  </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function submitContact(){
        $.ajax({
            url: '<?php echo $action; ?>',
            type: 'post',
            data: $("#contact-form").serialize(),
            dataType: 'json',
            beforeSend: function() {
            },
            success: function(json) {
                alert("Success");
            }
        });
    }
</script>