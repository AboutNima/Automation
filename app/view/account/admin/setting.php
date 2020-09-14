<div class="row">
    <div class="col-sm-4">
        <div class="row">
            <div class="col-12">
                <div class="text-center">
                    <img style="vertical-align: middle;border-radius: 50%" width="120px" src="/<?php echo !empty($_SESSION['Admin']['avatar']) ? $_SESSION['Admin']['avatar'] : 'public/account/panel/media/user.png' ?>" alt="">
                </div>
                <div class="hr dark"></div>
                <div class="block">
                    <div class="body">
                        <form action="/ajax/account/setting/avatar" class="ajax-handler form-validation" method="post">
                            <input type="text" name="Token" value="<?php echo $_SESSION['Token'] ?>" hidden>
                            <div class="input-mask mt-2 input-upload">
                                <input type="file" name="files">
                            </div>
                            <div class="hr" style="margin: 0;margin-bottom: -15px"></div>
                            <div class="input-mask no-mask-margin">
                                <button class="btn btn-purple"> آپلود آواتار </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="row">
            <div class="col-12">
                <div class="block">
                    <div class="header">
                        <h6> ویرایش اطلاعات حساب کاربری </h6>
                    </div>
                    <div class="body">
                        <form action="/ajax/account/setting/profile" class="ajax-handler form-validation" method="post">
                            <input type="text" name="Token" value="<?php echo $_SESSION['Token'] ?>" hidden>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="input-mask" input-validation="required" input-label="نام">
                                        <input type="text" autocomplete="off" value="<?php echo $_SESSION['Admin']['name'] ?>" name="data[name]">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="input-mask" input-validation="required" input-label="نام خانوادگی">
                                        <input autocomplete="off" type="text" value="<?php echo $_SESSION['Admin']['surname'] ?>" name="data[surname]">
                                    </div>
                                </div>
                            </div>
                            <div class="footer">
                                <div class="input-mask no-mask-margin">
                                    <input class="btn btn-default" type="reset" value="بازنویسی">
                                    <button class="btn btn-purple float-left"> ویرایش </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="block">
                    <div class="header">
                        <h6> ویرایش گذرواژه </h6>
                    </div>
                    <div class="body">
                        <form action="/ajax/account/setting/password" class="ajax-handler form-validation" method="post">
                            <input type="text" name="Token" value="<?php echo $_SESSION['Token'] ?>" hidden>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="input-mask" input-validation="required" input-label="گذرواژه فعلی">
                                        <input autocomplete="off" type="password" name="data[lastPassword]">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="input-mask" input-validation="required" input-label="گذرواژه جدید">
                                        <input autocomplete="off" type="password" name="data[password]">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="input-mask" input-validation="required" input-label="تکرار گذرواژه">
                                        <input autocomplete="off" type="password" name="data[confirmPassword]">
                                    </div>
                                </div>
                            </div>
                            <div class="footer">
                                <div class="input-mask no-mask-margin">
                                    <input class="btn btn-default" type="reset" value="بازنویسی">
                                    <button class="btn btn-purple float-left"> ویرایش </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>