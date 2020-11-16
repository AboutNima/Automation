<!doctype html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> پنل اختصاصی مدیریت هورباد </title>

    <link rel="stylesheet/less" href="/public/account/panel/app.less">
	<?php
	if(isset($link))
	{
		if(!is_array($link)) $link=[$link];
		foreach($link as $link)
		{
			echo "<link type='text/css' rel='stylesheet' href='{$link}.css'>";
		}
	}
	?>

</head>
<body>

<div class="chatroom">
    <div class="header">
        <p class="float-right" id="openChatroom"><i class="fal fa-comment-alt-dots"></i> چت روم </p>
        <span class="float-left" id="closeChatroom"><i class="fal fa-times"></i></span>
    </div>
    <div class="body">
        <div class="profile">
            <div>
                <img src="">
            </div>
            <div>
                <span class="name">#</span>
                <span class="status">#</span>
            </div>
        </div>
        <div class="panel">
            <ul>
				<?php
				foreach($adminChat as $item):
					?>
                    <li class="<?php echo strtr($item->online,['0'=>'offline','1'=>'online','2'=>'away']) ?> balloon" data-id="<?php echo $item->id ?>" balloon-position="right" balloon-text="<?php echo $item->name ?>" balloon-timeout="0">
                        <i class="unread" style="display: <?php if(empty($item->unread)) echo 'none'; ?>"><?php echo $item->unread ?></i>
                        <img src="/<?php echo empty($item->avatar) ? 'public/construct/media/user.png' : $item->avatar ?>" alt="">
                    </li>
				<?php
				endforeach;
				?>
            </ul>
        </div>
        <div class="chat">
            <div class="body">
                <div class="loader"><i class="far fa-spinner-third fa-spin"></i></div>
                <span id="unread">0</span>
                <ul></ul>
            </div>
            <div class="footer">
                <p> ارسال سریع با SHIFT+Enter و برای رفتن سر خط Enter </p>
                <textarea rows="1" placeholder="پیامی ارسال کنید ..." id="chatArea"></textarea>
                <div>
                    <i class="far fa-paper-plane fa-flip-horizontal" id="sendMessage" style="display: none"></i>
                    <i class="far fa-paperclip" id="sendFile"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="chat-notification">
    <ul></ul>
</div>

<div id="asideOpacity"></div>
<header>
    <div class="menu">
        <div class="float-left">
            <ul class="profile">
                <li><a href="#time" class="fsize-12" id="showTime"></a></li>
                <li class="balloon" balloon-position="bottom" balloon-text="اعلان های مدیریت"><i class="fal fa-bell"></i><span class="alert"></span></li>
                <li class="hv balloon" balloon-position="bottom" balloon-text="تنظیمات" onclick="location.replace('/account/setting')">
                    <img src="/<?php echo empty($_SESSION['Admin']['avatar']) ? 'public/construct/media/user.png' : $_SESSION['Admin']['avatar'] ?>" class="picture">
                </li>
            </ul>
        </div>
        <div class="float-right">
            <i class="fal fa-bars" id="showAside"></i>
        </div>
        <div class="float-right">
            <ul class="fast-access">
				<?php
				$url='';
				foreach($urlCrt as $key=>$item):
					$url.='/'.$urlPath[$key];
					?>
                    <li><a href="<?php echo $url ?>"><?php echo $item ?></a></li>
					<?php
					if(isset($urlPath[$key+1]) || $urlPath[$key+1]!=null):
						?>
                        <li><i class="fal fa-chevron-double-left"></i></li>
					<?php
					endif;
				endforeach;
				?>
            </ul>
        </div>
    </div>
</header>
<div class="page">
    <div class="aside-right">
        <div class="header">
            <div class="top">
                <p> اتوماسیون هورباد </p>
                <span id="minimizeAside"><i class="fal fa-bars"></i></span>
                <span id="hideAside"><i class="fal fa-times"></i></span>
            </div>
            <div class="profile">
                <p><?php echo $_SESSION['Admin']['name'].' '.$_SESSION['Admin']['surname'] ?></p>
                <div class="menu">
                    <ul>
                        <li><a href="/logout"><i class="fal fa-power-off"></i></a></li>
                        <li><a href="/account/setting"><i class="fal fa-cog"></i></a></li>
                    </ul>
                </div>
                <img src="/<?php echo empty($_SESSION['Admin']['avatar']) ? 'public/construct/media/user.png' : $_SESSION['Admin']['avatar'] ?>">
            </div>
        </div>
        <div class="body">
            <div class="menu">
                <ul>
                    <li><a href="/account"><i class="fad fa-cubes"></i><p> داشبورد </p></a></li>
					<?php
					if($_SESSION['Admin']['id']=='1'):
                    ?>
                        <li><a href="/account/manageAdmins"><i class="fad fa-users-crown"></i><p> مدیریت مدیران </p></a></li>
					<?php
					endif;
					?>
                    <li><a href="/account/news"><i class="fa fa-newspaper"></i><p>اخبار</p></a></li>
                    <li class="title"> آموزشگاه </li>
                    <li><a href="/account/students/list"><i class="fa fa-users"></i><p>کارآموزان</p></a></li>
                    <li><a href="/account/courses/list"><i class="fa fa-chalkboard"></i><p> دوره های آموزشی </p></a></li>
                    <li class="title"> حسابداری </li>
                    <li><a href="/account/accounting/title/list"><i class="fa fa-list"></i><p> سرفصل ها </p></a></li>
                    <li><a href="/account/accounting/costIncome/list"><i class="fa fa-list"></i><p> ثبت هزینه و درآمد </p></a></li>
                    <li class="title"> دیگر موارد </li>
                    <li><a href="/account/consumingMaterials/list"><i class="fa fa-wrench"></i><p>مواد مصرفی</p></a></li>
                    <li>
                        <span><i class="fad fa-qrcode"></i><p> سیستم اسکن مکانیزه </p>
                            <div class="dropdown">
                                <ul>
                                    <li><a href="/account/mechanizedScanning/tools/list"><i class="fas fa-circle"></i><p>  ابزار  </p></a></li>
                                    <li><a href="/account/mechanizedScanning/equipments/list"><i class="fas fa-circle"></i><p>  تجهیزات و امکانات  </p></a></li>
                                </ul>
                            </div>
						</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="page-content">
        <div id="ajax"></div>
        <div class="validation-message no-margin top"></div>
        <audio id="sendAudio">
            <source src="/public/account/panel/media/Send.mp3" type="audio/mpeg">
        </audio>
        <audio id="receiveAudio">
            <source src="/public/account/panel/media/Receive.mp3" type="audio/mpeg">
        </audio>