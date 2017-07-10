<div class="row portfolio">
    <div class="col-sm-12">
        <h2 class="accent">
            Here&apos;s What I&apos;ve Been Working On
        </h2>
    </div>
    <div class="col-sm-12">
        <h1></h1>
        <?php foreach($products as $product) { ?>
            <div categories="<?php echo $product['categories']; ?>" class="row portfolio-row">
                <div class="col-lg-5">
                    <?php if($product['href'] != "na") { ?>
                    <a target="_blank" href="<?php echo $product['href']; ?>">
                        <img src="<?php echo $product['thumb']; ?>" />
                    </a>
                    <?php } else { ?>
                    <img src="<?php echo $product['thumb']; ?>" />
                    <?php } ?>
                </div>
                <div class="col-lg-7">
                        <h2 class="project-title">
                                <?php if($product['href'] != "na") { ?>
                                    <a target="_blank" href="<?php echo $product['href']; ?>">
                                        <?php echo $product['name']; ?>
                                    </a>
                                <?php } else { ?>
                                    <?php echo $product['name']; ?>
                                <?php } ?>
                        </h2>
                        <div class="project-description">
                                <?php echo html_entity_decode($product['description']); ?>
                        </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
