<header style="height: 270px">
    <div class="background"></div>
    <div class="container">
        <div class="information">
            <h1> اخبار </h1>
        </div>
    </div>
</header>
<div class="container">
    <section class="latest-news">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        <?php
                        foreach($news as $key=>$item):
                            if($key==2) break;
                            ?>
                            <div class="col-lg-6">
                                <div class="news">
                                    <img src="/<?php echo $item->image ?>" alt="<?php echo $item->title ?>">
                                    <h6><?php echo $item->title ?></h6>
                                    <p><?php echo $item->demo ?></p>
                                    <a href="/news/<?php echo $item->link ?>"> مشاهده خبر </a>
                                </div>
                            </div>
                            <?php
                            unset($news[$key]);
                        endforeach;
                        ?>
                    </div>
                </div>
                <div class="col-lg-4">
                    <ul>
                        <?php
                        foreach($news as $item):
                            ?>
                            <li>
                                <a href="/news/<?php echo $item->link ?>">
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
                </div>
            </div>
        </div>
    </section>
</div>
