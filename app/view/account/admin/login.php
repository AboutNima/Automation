<!doctype html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> ورود به حساب کاربری اتوماسیون هورباد </title>
    <link rel="stylesheet/less" href="/public/login/app.less">
</head>
<body>

<div class="side-right">
    <div class="logo">

    </div>
    <div class="body">
        <h2> اتوماسیون هورباد </h2>
        <p> به اتوماسیون هورباد خوش آمدید. برای ورود نام و گذرواژه خود را در فرم مقابل وارد کنید. </p>
    </div>
    <div class="footer">
        <p><i class="fal fa-copyright"></i> تمامی حقوق محفوظ است </p>
    </div>
</div>
<div class="side-left">
    <div class="body">
        <div id="ajax"></div>
        <h3> ورود </h3>
        <form action="/ajax/account/admin" class="ajax-handler form-" method="post">
            <input type="text" name="Token" value="<?php echo $_SESSION['Token'] ?>" hidden>
            <div class="input-mask" input-validation="required">
                <input type="text" name="data[username]" autocomplete="off" placeholder="نام کاربری">
            </div>
            <div class="input-mask mt-2" input-validation="required">
                <input type="password" name="data[password]" autocomplete="off" placeholder="گذرواژه">
            </div>
            <div class="validation-message"></div>
            <div class="mt-2 mb-4">
                <hr>
            </div>
            <div class="input-mask no-mask-margin">
                <button class="btn btn-purple float-left"> ورود به حساب </button>
            </div>
        </form>
    </div>
</div>

<script>
    less={
        env:'development'
    }
</script>
<script src="/public/construct/less.min.js"></script>
<script src="/public/construct/jquery.min.js"></script>
<script src="/public/construct/input/input.js"></script>
<script src="/public/construct/input/form-validation.js"></script>
<script src="/public/construct/input/ajax-handler.js"></script>
<script src="/public/construct/validationMessage/validation.js"></script>
<script src="/public/login/script.js"></script>
</body>
</html>