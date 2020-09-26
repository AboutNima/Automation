<div class="row">
    <div class="col-md-6">
        <div class="block">
            <div class="header">
                <div class="title">
                    <h6> تنظیمات حساب کاربری </h6>
                    <p> در این قسمت میتوانید اطلاعات حساب کاربری خود را ویرایش کنید </p>
                </div>
            </div>
            <div class="body">
                <div class="avatar text-center">
                    <img style="width: 115px;height: 115px;border-radius: 50%;" src="/<?php echo !empty($_SESSION['Admin']['avatar']) ? $_SESSION['Admin']['avatar'] : 'public/construct/media/user.png' ?>">
                </div>
                <form action="/ajax/account/admin/setting/profile" class="ajax-handler" method="post">
                    <input type="text" name="Token" value="<?php echo $_SESSION['Token'] ?>" hidden>
                    <div class="row">
                        <div class="col-12">
                            <div class="input-mask required" mask-type="upload:0.5MB,jpg-jpeg-png-tiff" mask-label="آواتار (انتخاب عکس جدید)">
                                <input type="file" name="file">
                            </div>
                            <p class="text-danger fsize-13 mt-0 fism"> * برای با کیفیت بودن آواتار، ابعاد آن را به  250x250 (مربع) تغییر دهید </p>
                            <br>
                        </div>
                        <div class="col-sm-6">
                            <div class="input-mask required" mask-type mask-label="نام">
                                <input type="text" name="data[name]" autocomplete="off" value="<?php echo $_SESSION['Admin']['name'] ?>">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input-mask required" mask-type mask-label="نام خانوادگی">
                                <input type="text" name="data[surname]" autocomplete="off" value="<?php echo $_SESSION['Admin']['surname'] ?>">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input-mask required" mask-type mask-label="کد ملی">
                                <input type="text" name="data[nationalCode]" autocomplete="off" value="<?php echo $_SESSION['Admin']['nationalCode'] ?>">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input-mask required" mask-type mask-label="شماره همراه">
                                <input type="text" name="data[phoneNumber]" autocomplete="off" value="<?php echo $_SESSION['Admin']['phoneNumber'] ?>">
                            </div>
                        </div>
                    </div>
                    <div class="clearFix">
                        <div class="hr"></div>
                        <div class="input-mask no-mask-margin">
                            <button class="btn btn-purple float-left"> ویرایش اطلاعات </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="block">
            <div class="header">
                <div class="title">
                    <h6> ویرایش گذرواژه </h6>
                    <p> در این قسمت میتوانید گذرواژه حساب کاربری خود را ویرایش کنید </p>
                </div>
            </div>
            <div class="body">
                <form action="/ajax/account/admin/setting/changePassword" class="ajax-handler" method="post">
                    <input type="text" name="Token" value="<?php echo $_SESSION['Token'] ?>" hidden>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="input-mask required" mask-type mask-label="گذرواژه جدید">
                                <input type="password" name="data[new]" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input-mask required" mask-type mask-label="تکرار گذرواژه جدید">
                                <input type="password" name="data[repeat]" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-mask required" mask-type mask-label="گذرواژه فعلی">
                                <input type="password" name="data[yet]" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="clearFix">
                        <div class="hr"></div>
                        <div class="input-mask no-mask-margin">
                            <button class="btn btn-purple float-left"> ویرایش گذرواژه </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>