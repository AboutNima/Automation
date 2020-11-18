<header style="height: 270px">
    <div class="background"></div>
    <div class="container">
        <div class="information">
            <h1><?php echo $data->title ?></h1>
        </div>
    </div>
</header>
<br><br>
<div class="container">
    <div class="row">
        <div class="col-lg-7 offset-lg-1">
            <div class="block-news">
                <div class="header">
                    <h1><?php echo $data->title ?></h1>
                    <p><?php echo $data->demo ?></p>
                    <span><i class="far fa-clock"></i><?php echo $calendar->date("j F Y",$data->createdAt) ?></span>
                    <img src="/<?php echo $data->image ?>" alt="<?php echo $data->title ?>">
                </div>
                <div class="body">
                    <div><?php echo $data->description ?></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <section class="latest-news">
                <ul>
                    <?php
                    foreach($news as $item):
                        ?>
                        <li>
                            <a href="<?php echo $item->link ?>">
                                <img src="/<?php echo $item->image ?>" alt="<?php echo $item->title ?>">
                                <div class="description">
                                    <h6><?php echo $item->title ?></h6>
                                    <p><?php echo $item->demo ?></p>
                                    <span><?php echo $calendar->date("j F Y",$item->createdAt) ?></span>
                                </div>
                            </a>
                        </li>
                    <?php
                    endforeach;
                    ?>
            </ul>
            </section>
        </div>
    </div>
</div>