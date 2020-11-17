<!DOCTYPE html>
<html lang="fa">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title> آموزشگاه فنی حرفه ای آزاد هورباد </title>
	<link rel="stylesheet/less" type="text/css" href="/public/home/app.less">
</head>
<body>

<nav>
	<div class="container">
		<ul class="menu float-right">
			<li class="logo">
				<a href="/">
					<img src="/public/home/media/logo.png" alt="">
					<img src="/public/home/media/logoColorize.png" alt="">
				</a>
			</li>
			<li><a href="#"> صفحه اصلی </a></li>
			<li><a href="#"> مجوزات </a></li>
			<li><a href="#"> دوره های آموزشی </a></li>
			<li><a href="#"> گالری عکس </a></li>
			<li><a href="#"> اخبار </a></li>
			<li><a href="#"> تماس با ما </a></li>
		</ul>
		<ul class="menu float-left">
			<li class="account"><a href="#"> ورود / عضویت </a></li>
		</ul>
	</div>
</nav>
<header>
	<div class="background"></div>
	<div class="container">
		<div class="information">
			<h1> آموزشگاه فنی حرفه ای آزاد <span class="text-warning-logo">هور</span>باد </h1>
			<p> لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است </p>
			<div class="link">
				<a href="#"> تماس با ما </a>
				<a href="#"> ثبت نام در دوره </a>
			</div>
		</div>
	</div>
</header>
<div class="container">
	<div class="features">
		<div class="row">
			<div class="col-md-4">
				<div class="item">
					<i class="fad fa-file-certificate"></i>
					<h5> دعوت به کار نفرات برتر </h5>
					<p> آموزشگاه فنی حرفه ای آزاد <span class="text-warning-logo">هور</span><span class="text-primary-logo">باد</span> پس از اتمام دوره، از نفرات برتر دعوت به همکاری میکند! </p>
				</div>
			</div>
			<div class="col-md-4">
				<div class="item">
					<i class="fad fa-wrench"></i>
					<h5> برگزاری آموزش های تئوری و عملی </h5>
					<p> آموزشگاه فنی حرفه ای آزاد <span class="text-warning-logo">هور</span><span class="text-primary-logo">باد</span> پس از اتمام دوره، از نفرات برتر دعوت به همکاری میکند! </p>
				</div>
			</div>
			<div class="col-md-4">
				<div class="item">
					<i class="fad fa-users-cog"></i>
					<h5> حضور در پروژه های در دست انجام</h5>
					<p> آموزشگاه فنی حرفه ای آزاد <span class="text-warning-logo">هور</span><span class="text-primary-logo">باد</span> پس از اتمام دوره، از نفرات برتر دعوت به همکاری میکند! </p>
				</div>
			</div>
		</div>
	</div>
</div>
<section class="block teachers">
	<div class="container">
		<div class="header">
			<div>
				<p> اساتید حرفه ای </p>
				<h5> استفاده از برترین اساتید </h5>
				<span></span>
			</div>
		</div>
		<div class="body">
			<div class="row">
                <?php
                foreach($teachers['Result'] as $item):
                ?>
                    <div class="col-lg-4">
                        <div class="item">
                            <img src="http://dskills.ir/<?php echo $item['avatar'] ?>" alt="<?php echo $item['name'] ?>">
                            <h6><?php echo $item['name'] ?></h6>
                            <p><?php echo $item['biography'] ?></p>
                        </div>
                    </div>
                <?php
                endforeach;
                ?>
			</div>
		</div>
	</div>
</section>
<section class="block best-course">
	<div class="container">
		<div class="header">
			<div class="float-right">
				<p> پیشنهاد ویژه </p>
				<h5> برترین دوره های آموزشی </h5>
				<span></span>
			</div>
			<div class="float-left">
				<a href="#"> همه دوره ها <i class="fal fa-angle-double-left"></i> </a>
			</div>
		</div>
		<div class="body">
			<div class="slick-slider" style="margin: 0 -15px">
                <?php
                foreach($courses['Result'] as $item):
                ?>
                    <div class="item">
                        <div class="course">
                            <div class="header">
                                <img src="http://dskills.ir/<?php echo $item['poster'] ?>" alt="<?php echo $item['title'] ?>">
                            </div>
                            <div class="body">
                                <div class="top-bar">
                                    <p> سطح حرفه ای </p>
                                    <span><i class="far fa-heart"></i></span>
                                </div>
                                <div class="title">
                                    <h5><?php echo $item['title'] ?></h5>
                                    <p><?php echo $item['teacherName'] ?></p>
                                    <div class="star">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <span>3.2</span>
                                    </div>
                                </div>
                                <div class="information">
                                    <ul>
                                        <li><i class="far fa-clock"></i><p> 2 ساعت و 30 دقیقه </p></li>
                                    </ul>
                                </div>
                                <div class="payment">
                                    <p><?php echo number_format($item['price']/10) ?> تومان </p>
                                    <a href="#"> ثبت نام </a>
                                </div>
                            </div>
                        </div>
                    </div>
				<?php
                endforeach;
                ?>
			</div>
		</div>
		<div slick-dots></div>
	</div>
</section>
<section class="block they-say">
	<div class="container no-width">
		<div class="header">
			<h6> شرکت کنندگان چه میگویند </h6>
			<span></span>
		</div>
		<div class="body">
			<div class="slick-slider" style="margin: 0 -15px">
				<div class="item">
					<div class="top-bar">
						<img src="/public/home/media/user/3.jpg" alt="">
						<div>
							<p> نیما اسعدی </p>
							<span> دوره نصاب و تعمیر کار کولر های گازی پنجره ای و اسپلیت </span>
							<div class="star">
								<i class="fas fa-star"></i>
								<i class="fas fa-star"></i>
								<i class="fas fa-star"></i>
								<i class="far fa-star"></i>
								<i class="far fa-star"></i>
							</div>
						</div>
					</div>
					<div class="text">
						<p>
							لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی
							لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی
						</p>
					</div>
				</div>
				<div class="item">
					<div class="top-bar">
						<img src="/public/home/media/user/3.jpg" alt="">
						<div>
							<p> نیما اسعدی </p>
							<span> دوره نصاب و تعمیر کار کولر های گازی پنجره ای و اسپلیت </span>
							<div class="star">
								<i class="fas fa-star"></i>
								<i class="fas fa-star"></i>
								<i class="fas fa-star"></i>
								<i class="far fa-star"></i>
								<i class="far fa-star"></i>
							</div>
						</div>
					</div>
					<div class="text">
						<p>
							لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی
							لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی
						</p>
					</div>
				</div>
				<div class="item">
					<div class="top-bar">
						<img src="/public/home/media/user/3.jpg" alt="">
						<div>
							<p> نیما اسعدی </p>
							<span> دوره نصاب و تعمیر کار کولر های گازی پنجره ای و اسپلیت </span>
							<div class="star">
								<i class="fas fa-star"></i>
								<i class="fas fa-star"></i>
								<i class="fas fa-star"></i>
								<i class="far fa-star"></i>
								<i class="far fa-star"></i>
							</div>
						</div>
					</div>
					<div class="text">
						<p>
							لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی
							لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی
						</p>
					</div>
				</div>
				<div class="item">
					<div class="top-bar">
						<img src="/public/home/media/user/3.jpg" alt="">
						<div>
							<p> نیما اسعدی </p>
							<span> دوره نصاب و تعمیر کار کولر های گازی پنجره ای و اسپلیت </span>
							<div class="star">
								<i class="fas fa-star"></i>
								<i class="fas fa-star"></i>
								<i class="fas fa-star"></i>
								<i class="far fa-star"></i>
								<i class="far fa-star"></i>
							</div>
						</div>
					</div>
					<div class="text">
						<p>
							لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی
							لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی
						</p>
					</div>
				</div>
				<div class="item">
					<div class="top-bar">
						<img src="/public/home/media/user/3.jpg" alt="">
						<div>
							<p> نیما اسعدی </p>
							<span> دوره نصاب و تعمیر کار کولر های گازی پنجره ای و اسپلیت </span>
							<div class="star">
								<i class="fas fa-star"></i>
								<i class="fas fa-star"></i>
								<i class="fas fa-star"></i>
								<i class="far fa-star"></i>
								<i class="far fa-star"></i>
							</div>
						</div>
					</div>
					<div class="text">
						<p>
							لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی
							لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی
						</p>
					</div>
				</div>
			</div>
			<div slick-dots></div>
		</div>
	</div>
</section>
<footer>
	<div class="top-bar">
		<div class="container">
			<div class="body">
				<div>
					<h3> از هیچ دوره ای <span class="text-danger"> بی اطلاع </span> نمانید! </h3>
					<form>
						<div class="input-mask no-mask-margin" mask-type>
							<input type="text" placeholder="شماره همراه خود را وارد کنید">
							<button class="btn btn-warning"> ثبت شماره </button>
						</div>
					</form>
				</div>
				<div class="hr"></div>
				<p>
					لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد کتابهای زیادی در شصت و سه درصد گذشته حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها
				</p>
				<img src="/public/home/media/eNamad.png" alt="">
			</div>
		</div>
	</div>
	<div class="bottom-bar">
		<div class="container">
			<div class="row">
				<div class="col-lg-4">
					<div class="item">
						<h5><i class="fas fa-circle"></i>  لینک های مفید </h5>
						<ul>
							<li><a href="#"> سامانه آموزش مجازی <span class="text-warning-logo">هور</span><span class="text-primary-logo">باد</span> متصل به اسکایروم </a></li>
							<li><a href="#"> LMS آموزش مجازی آموزشگاه فنی حرفه ای <span class="text-warning-logo">هور</span><span class="text-primary-logo">باد</span> </a></li>
							<li><a href="#"> آموزش ثبت نام در سایت <span class="text-warning-logo">هور</span><span class="text-primary-logo">باد</span> </a></li>
							<li><a href="#"> سایت سازمان فنی حرفه ای کشور </a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="item">
						<h5><i class="fas fa-circle"></i> دسترسی سریع </h5>
						<ul>
							<li>
								<a href="#"> ورود به سامانه </a>
								<a href="#"> ثبت نام کار آموز </a>
								<a href="#"> شرکت در دوره آموزشی </a>
								<a href="#"> نحوه شرکت در آزمون </a>
							</li>
							<li>
								<a href="#"> درباره آموزشگاه <span class="text-warning-logo">هور</span><span class="text-primary-logo">باد</span> </a>
								<a href="#"> تماس با ما </a>
								<a href="#"> فرم نظرسنجی </a>
							</li>
							<li>
								<a href="#"> سوالات متداول </a>
							</li>
						</ul>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="item">
						<h5><i class="fas fa-circle"></i> شبکه های اجتماعی </h5>
						<ul>
							<li>
								<a href="#"> اینستاگرام </a>
								<a href="#"> کانال تلگرام  </a>
								<a href="#"> تویتر </a>
							</li>
							<li><a href="#">  </a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="copy-right">
		<div class="container">
			<p> تمامی حقوق برای شرکت آموزشگاه فنی حرفه ای آزاد <span class="text-warning-logo">هور</span><span class="text-primary-logo">باد</span> محفوظ میباشد. 1399-1400 </p>
		</div>
	</div>
</footer>

<script>
    less={
        env:'development'
    }
</script>
<script type="text/javascript" src="/public/construct/less.min.js"></script>
<script type="text/javascript" src="/public/construct/jquery.min.js"></script>
<script type="text/javascript" src="/public/construct/input/input.js"></script>
<script type="text/javascript" src="/public/construct/balloon/balloon.js"></script>
<script type="text/javascript" src="/public/construct/slick/slick.min.js"></script>
<script type="text/javascript" src="/public/home/script.js"></script>
</body>
</html>