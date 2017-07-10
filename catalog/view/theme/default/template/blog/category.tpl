<?php echo $header; ?>
<h1 class="accent page-title"><?php echo $heading_title; ?></h1>
<hr />
<div id="content" class="<?php echo $class; ?> background-light"><?php echo $content_top; ?>
         <div class="row">
            <div class="container">
              <div class="row"><?php echo $column_left; ?>
                <?php if ($column_left && $column_right) { ?>
                <?php $class = 'col-sm-6'; ?>
                <?php } elseif ($column_left || $column_right) { ?>
                <?php $class = 'col-sm-9'; ?>
                <?php } else { ?>
                <?php $class = 'col-sm-12'; ?>
                <?php } ?>
                <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
                  <?php if ($description) { ?>
                  <div class="row">
                    <?php if ($description) { ?>
                    <div class="col-sm-10"><?php echo $description; ?></div>
                    <?php } ?>
                  </div>
                  <hr>
                  <?php } ?>
                  <?php if ($blog_posts) { ?>
                  <br />
                  <div class="row">
                    <?php foreach ($blog_posts as $blog_post) { ?>
                    <div class="background-dark blog_post-layout blog_post-list col-xs-12">
                      <div class="blog_post-thumb">
                            <?php if(isset($blog_post['image']) && $blog_post['image'] != "") { ?>
                                <a href="<?php echo $blog_post['href']; ?>"><img src="<?php echo HTTPS_SERVER . "image/" . $blog_post['image']; ?>" /></a>
                            <?php } ?>
                        <div>
                          <div class="caption">
                            <h4><a class="accent" href="<?php echo $blog_post['href']; ?>"><?php echo $blog_post['title']; ?></a></h4>
                            <br />
                            <hr />
                            <br />
                            <p><?php echo $blog_post['description']; ?></p>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php } ?>
                  </div>
                  <div class="row">
                    <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
                    <div class="col-sm-6 text-right"><?php echo $results; ?></div>
                  </div>
                  <?php } ?>
                  <?php if (!$blog_posts) { ?>
                  <p><?php echo $text_empty; ?></p>
                  <div class="buttons">
                    <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
                  </div>
                  <br /><br />
                  <?php } ?>
                  <?php echo $content_bottom; ?></div>
                <?php echo $column_right; ?></div>
                
              <ul class="breadcrumb">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
                <?php } ?>
              </ul>
            </div>
         </div>
</div>
<?php echo $footer; ?>
