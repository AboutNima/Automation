<header style="height: 270px">
    <div class="background"></div>
    <div class="container">
        <div class="information">
            <h1> مجوزات </h1>
        </div>
    </div>
</header>

<section class="certificates">
    <div class="container">
        <div class="row">
            <?php
            foreach($certificates as $item):
            ?>
                <div class="col-lg-4">
                    <div class="item">
                        <img src="/<?php echo $item->photo ?>" alt="<?php echo $item->title ?>">
                        <div class="body">
                            <h6><?php echo $item->title ?></h6>
                            <p><?php echo $item->description ?></p>
                        </div>
                    </div>
                </div>
            <?php
            endforeach;
            ?>
        </div>
    </div>
</section>