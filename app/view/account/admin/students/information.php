<div class="block">
	<div class="header">
		<div class="title">
			<h6>مشخصات کارآموز <?php echo $data->name.' '.$data->surname ?></h6>
		</div>
	</div>
	<div class="body">
		<div class="row">
			<div class="col-sm-3">
				<div class="input-mask" mask-type mask-label="نام">
					<input type="text" value="<?php echo $data->name ?>" disabled>
				</div>
			</div>
			<div class="col-sm-3">
				<div class="input-mask" mask-type mask-label="نام خانوادگی">
					<input type="text" value="<?php echo $data->surname ?>" disabled>
				</div>
			</div>
			<div class="col-sm-3">
				<div class="input-mask" mask-type mask-label="نام (انگلیسی)">
					<input type="text" value="<?php echo $data->name ?>" disabled>
				</div>
			</div>
			<div class="col-sm-3">
				<div class="input-mask" mask-type mask-label="نام خانوادگی (انگلیسی)">
					<input type="text" value="<?php echo $data->surname ?>" disabled>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="input-mask" mask-type mask-label="نام پدر">
					<input type="text" value="<?php echo $data->fatherName ?>" disabled>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="input-mask" mask-type mask-label="کد ملی">
					<input type="text" value="<?php echo $data->nationalCode ?>" disabled>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="input-mask" mask-type mask-label="شماره شناسنامه">
					<input type="text" value="<?php echo $data->birthCNumber ?>" disabled>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="input-mask" mask-type mask-label="شماره تلفن همراه">
					<input type="text" value="<?php echo $data->phoneNumber ?>" disabled>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="input-mask" mask-type mask-label="شماره تلفن ثابت">
					<input type="text" value="<?php echo $data->homeNumber ?>" disabled>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="input-mask" mask-type mask-label="تاریخ تولد">
					<input type="text" value="<?php echo $data->birthDay ?>" disabled>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="input-mask" mask-type mask-label="میزان تحصیلات">
					<input type="text" value="<?php echo $data->education ?>" disabled>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="input-mask" mask-type mask-label="شغل">
					<input type="text" value="<?php echo $data->job ?>" disabled>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="input-mask" mask-type mask-label="تاریخ ایجاد">
					<input type="text" value="<?php echo $data->createdAt ?>" disabled>
				</div>
			</div>
			<div class="col-sm-12">
				<div class="input-mask" mask-type mask-label="آدرس">
					<input type="text" value="<?php echo $data->address ?>" disabled>
				</div>
			</div>
		</div>
	</div>
</div>