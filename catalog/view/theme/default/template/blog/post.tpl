<?php echo $header; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-8 col-sm-offset-2'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <h1><?php echo $heading_title; ?></h1>
      <div  class="help-block"><?php echo $text_posted_by; ?></div>
      <?php echo $description; ?>

      <!-- AddThis Button BEGIN -->
      <div class="addthis_toolbox addthis_default_style"><a class="addthis_button_facebook_like" fb:like:layout="button_count"></a> <a class="addthis_button_tweet"></a> <a class="addthis_button_pinterest_pinit"></a> <a class="addthis_counter addthis_pill_style"></a></div>
      <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-515eeaf54693130e"></script>
      <!-- AddThis Button END -->

    <div class="contain" >
        <form class="form-horizontal">
          <div id="comment"></div>
          <h2><?php echo $text_write; ?></h2>
          <?php //if ($comment_guest) { ?>
          <div class="form-group required">
            <div class="col-sm-12">
              <label class="control-label" for="input-name"><?php echo $entry_name; ?></label>
              <input type="text" name="name" value="" id="input-name" class="form-control" />
            </div>
          </div>
          <div class="form-group required">
            <div class="col-sm-12">
              <label class="control-label" for="input-email"><?php echo $entry_email; ?></label>
              <input type="email" name="email" value="" id="input-email" class="form-control" />
              <span class="help"><?php echo $help_email; ?></span>
            </div>
          </div>                
          <div class="form-group required">
            <div class="col-sm-12">
              <label class="control-label" for="input-comment"><?php echo $entry_comment; ?></label>
              <textarea name="text" rows="5" id="input-comment" class="form-control"></textarea>
              <div class="help-block"><?php echo $text_note; ?></div>
            </div>
          </div>
         <?php if ($site_key) { ?>
            <div class="form-group">
              <div class="col-sm-12">
                <div class="g-recaptcha" data-sitekey="<?php echo $site_key; ?>"></div>
              </div>
            </div>
          <?php } ?>
          <div class="buttons clearfix">
            <div class="pull-right">
              <button type="button" id="button-comment" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><?php echo $button_continue; ?></button>
            </div>
          </div>
          <?php //} else { ?>
          <?php //echo $text_login; ?>
          <?php //} ?>
        </form>
      </div>

      <?php if ($tags) { ?>
      <p><?php echo $text_tags; ?>
        <?php for ($i = 0; $i < count($tags); $i++) { ?>
        <?php if ($i < (count($tags) - 1)) { ?>
        <a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a>,
        <?php } else { ?>
        <a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a>
        <?php } ?>
        <?php } ?>
      </p>
      <?php } ?>      
    </div>

    <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<script type="text/javascript"><!--
$('#comment').delegate('.pagination a', 'click', function(e) {
  e.preventDefault();

    $('#comment').fadeOut('slow');

    $('#comment').load(this.href);

    $('#comment').fadeIn('slow');
});

$('#comment').load('index.php?route=blog/post/comment&blog_post_id=<?php echo $blog_post_id; ?>');

$('#button-comment').on('click', function() {
  $.ajax({
    url: 'index.php?route=blog/post/write&blog_post_id=<?php echo $blog_post_id; ?>',
    type: 'post',
    dataType: 'json',
    data: 'name=' + encodeURIComponent($('input[name=\'name\']').val()) + '&email=' + encodeURIComponent($('input[name=\'email\']').val()) + '&text=' + encodeURIComponent($('textarea[name=\'text\']').val()),
    beforeSend: function() {
      $('#button-comment').button('loading');
    },
    complete: function() {
      $('#button-comment').button('reset');
    },
    success: function(json) {
      $('.alert-success, .alert-danger').remove();

      if (json['error']) {
        $('#comment').after('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
      }

      if (json['success']) {
        $('#comment').after('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');

        $('input[name=\'name\']').val('');
         $('input[name=\'email\']').val('');
        $('textarea[name=\'text\']').val('');
        
      }
    }
  });
});

//--></script>
<?php echo $footer; ?>