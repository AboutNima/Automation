<?php
switch($urlPath[1])
{
	case 'account':
		switch($urlPath[2])
		{
			case 'admin':
				if(isset($_SESSION['Admin']))
				{
					switch($urlPath[3])
					{
						case 'mechanizedScanning':
							switch($urlPath[4])
							{
								case 'tools':
									switch($urlPath[5])
									{
										case 'add':
											if(!isset($_POST['Token']) || $_POST['Token']!=$_SESSION['Token']) die();
											if(isset($_POST['data']))
											{
												$data=$_POST['data'];
												$validation=new Validation($data,[
													'type'=>['required[دسته بندی]','in[انتخاب,دسته بندی]:'.implode(',',array_keys(ToolsType))],
													'size'=>['required[سایز]','length[سایز,حداکثر,10]:max,10'],
													'company'=>['required[شرکت سازنده]','length[شرکت سازنده,حداکثر,100]:max,100'],
													'propertyNumber'=>['max[شماره اموال,9999]:9999','min[شماره اموال,1]:1'],
													'description'=>['length[توضیحات,حداکثر,100]:max,100','length[توضیحات,حداقل,10]:min,10'],
													'count'=>['required[موجودی]','numeric[موجودی]']
												]);
												if($validation->getStatus()){
													die(json_encode([
														'type'=>'danger',
														'msg'=>$validation->getErrors(),
														'err'=>-1,
														'data'=>null
													]));
												}
												if(empty($data['propertyNumber'])) $data['propertyNumber']=null;
												$data['QRCode']=randomText(25);
												$id=$db->insert('MST',$data);
												if((bool)$id)
												{
													die(json_encode([
														'type'=>'success',
														'msg'=>'ابزار جدید با موفقیت ایجاد شد',
														'err'=>null,
														'data'=>null
													]));
												}else{
													if($db->getLastErrno()==1062)
													{
														die(json_encode([
															'type'=>'warning',
															'msg'=>'این شماره اموال قبلا در سیستم ثبت شده',
															'err'=>0,
															'data'=>null
														]));
													}else{

														die(json_encode([
															'type'=>'warning',
															'msg'=>'مشکلی در انجام درخواست شما پیش آمده. با پشتیبان سایت تماس بگیرید و کد ('.$db->getLastErrno().') را اعلام نمایید',
															'err'=>-2,
															'data'=>null
														]));
													}
												}
											}
											break;
										case 'getData':
											if(isset($_POST['id']))
											{
												$_SESSION['DATA']['MechanizedScanning']['Tools']['EDIT']['ID']=$_POST['id'];
												echo $db->where('id',$_POST['id'])->jsonBuilder()->getOne('MST',[
													'type','size','company','propertyNumber','description','count'
												]);
											}
											break;
										case 'getSubData':
											if(isset($_POST['id']))
											{
												$_SESSION['DATA']['MechanizedScanning']['Tools']['SUB']['EDIT']['ID']=$_POST['id'];
												echo $db->where('id',$_POST['id'])->jsonBuilder()->getOne('MST',[
													'type','size','company','description','count'
												]);
											}
											break;
										case 'edit':
											if(!isset($_POST['Token']) || $_POST['Token']!=$_SESSION['Token']) die();
											if(isset($_POST['data']) && isset($_SESSION['DATA']['MechanizedScanning']['Tools']['EDIT']['ID']))
											{
												$data=$_POST['data'];
												$validation=new Validation($data,[
													'type'=>['required[دسته بندی]','in[انتخاب,دسته بندی]:'.implode(',',array_keys(ToolsType))],
													'size'=>['required[سایز]','length[سایز,حداکثر,10]:max,10'],
													'company'=>['required[شرکت سازنده]','length[شرکت سازنده,حداکثر,100]:max,100'],
													'propertyNumber'=>['max[شماره اموال,9999]:9999','min[شماره اموال,1]:1'],
													'description'=>['length[توضیحات,حداکثر,100]:max,100','length[توضیحات,حداقل,10]:min,10'],
													'count'=>['required[موجودی]','numeric[موجودی]']
												]);
												if($validation->getStatus()){
													die(json_encode([
														'type'=>'danger',
														'msg'=>$validation->getErrors(),
														'err'=>-1,
														'data'=>null
													]));
												}
												$check=$db->where('id',$_SESSION['DATA']['MechanizedScanning']['Tools']['EDIT']['ID'])->
												update('MST',$data,1);
												if($check)
												{
													die(json_encode([
														'type'=>'success',
														'msg'=>'ابزار با موفقیت ویرایش شد',
														'err'=>null,
														'data'=>null
													]));
												}else{
													if($db->getLastErrno()==1062)
													{
														die(json_encode([
															'type'=>'warning',
															'msg'=>'این شماره اموال قبلا در سیستم ثبت شده',
															'err'=>0,
															'data'=>null
														]));
													}else{

														die(json_encode([
															'type'=>'warning',
															'msg'=>'مشکلی در انجام درخواست شما پیش آمده. با پشتیبان سایت تماس بگیرید و کد ('.$db->getLastErrno().') را اعلام نمایید',
															'err'=>-2,
															'data'=>null
														]));
													}
												}
											}
											break;
										case 'addSub':
											if(!isset($_POST['Token']) || $_POST['Token']!=$_SESSION['Token']) die();
											if(isset($_POST['data']) && isset($_SESSION['DATA']['MechanizedScanning']['Tools']['ID']))
											{
												$data=$_POST['data'];
												$validation=new Validation($data,[
													'size'=>['required[سایز]','length[سایز,حداکثر,10]:max,10'],
													'company'=>['required[شرکت سازنده]','length[شرکت سازنده,حداکثر,100]:max,100'],
													'description'=>['length[توضیحات,حداکثر,100]:max,100','length[توضیحات,حداقل,10]:min,10'],
													'count'=>['required[موجودی]','numeric[موجودی]']
												]);
												if($validation->getStatus()){
													die(json_encode([
														'type'=>'danger',
														'msg'=>$validation->getErrors(),
														'err'=>-1,
														'data'=>null
													]));
												}
												if(empty($data['propertyNumber'])) $data['propertyNumber']=null;
												$data['QRCode']=randomText(25);
												$data['subId']=$_SESSION['DATA']['MechanizedScanning']['Tools']['ID'];
												$data['type']=$_SESSION['DATA']['MechanizedScanning']['Tools']['TYPE'];
												$id=$db->insert('MST',$data);
												if((bool)$id)
												{
													die(json_encode([
														'type'=>'success',
														'msg'=>'ابزار جدید با موفقیت ایجاد شد',
														'err'=>null,
														'data'=>null
													]));
												}else{
													if($db->getLastErrno()==1062)
													{
														die(json_encode([
															'type'=>'warning',
															'msg'=>'این شماره اموال قبلا در سیستم ثبت شده',
															'err'=>0,
															'data'=>null
														]));
													}else{

														die(json_encode([
															'type'=>'warning',
															'msg'=>'مشکلی در انجام درخواست شما پیش آمده. با پشتیبان سایت تماس بگیرید و کد ('.$db->getLastErrno().') را اعلام نمایید',
															'err'=>-2,
															'data'=>null
														]));
													}
												}
											}
											break;
										case 'editSub':
											if(!isset($_POST['Token']) || $_POST['Token']!=$_SESSION['Token']) die();
											if(isset($_POST['data']) && isset($_SESSION['DATA']['MechanizedScanning']['Tools']['SUB']['EDIT']['ID']))
											{
												$data=$_POST['data'];
												$validation=new Validation($data,[
													'type'=>['required[دسته بندی]','in[انتخاب,دسته بندی]:'.implode(',',array_keys(ToolsType))],
													'size'=>['required[سایز]','length[سایز,حداکثر,10]:max,10'],
													'company'=>['required[شرکت سازنده]','length[شرکت سازنده,حداکثر,100]:max,100'],
													'description'=>['length[توضیحات,حداکثر,100]:max,100','length[توضیحات,حداقل,10]:min,10'],
													'count'=>['required[موجودی]','numeric[موجودی]']
												]);
												if($validation->getStatus()){
													die(json_encode([
														'type'=>'danger',
														'msg'=>$validation->getErrors(),
														'err'=>-1,
														'data'=>null
													]));
												}
												$check=$db->where('ID',$_SESSION['DATA']['MechanizedScanning']['Tools']['SUB']['EDIT']['ID'])->
												update('MST',$data,1);
												if($check){
													die(json_encode([
														'type'=>'success',
														'msg'=>'ابزار با موفقیت ویرایش شد',
														'err'=>null,
														'data'=>null
													]));
												}else{
													die(json_encode([
														'type'=>'warning',
														'msg'=>'مشکلی در انجام درخواست شما پیش آمده. با پشتیبان سایت تماس بگیرید و کد ('.$db->getLastErrno().') را اعلام نمایید',
														'err'=>-2,
														'data'=>null
													]));
												}
											}
											break;
									}
									break;
								case 'equipments':
									switch($urlPath[5])
									{
										case 'add':
											if(!isset($_POST['Token']) || $_POST['Token']!=$_SESSION['Token']) die();
											if(isset($_POST['data'])){
												$data=$_POST['data'];
												if(!isset($data['accessories'])) $data['accessories']=0;
												$validation=new Validation($data,[
													'name'=>['required[نام]','length[100,سایز,حداکثر]:max,100'],
													'brand'=>['length[برند,حداکثر,100]:max,100'],
													'propertyNumber'=>['required[شماره اموال]','max[شماره اموال,9999]:9999','min[شماره اموال,1]:1'],
													'accessories'=>'in[انتخاب,لوازم جانبی]:0,1',
													'description'=>['length[توضیحات,حداکثر,100]:max,100','length[توضیحات,حداقل,10]:min,10'],
													'count'=>['required[تعداد]','numeric[تعداد]'],
													'status'=>'in[انتخاب,وضعیت]:0,1'
												]);
												if($validation->getStatus()){
													die(json_encode([
														'type'=>'danger',
														'msg'=>$validation->getErrors(),
														'err'=>-1,
														'data'=>null
													]));
												}
												$data['QRCode']=randomText(25);
												$id=$db->insert('Eq',$data);
												if((bool)$id){
													die(json_encode([
														'type'=>'success',
														'msg'=>'ابزار جدید با موفقیت ایجاد شد',
														'err'=>null,
														'data'=>null
													]));
												}else{
													if($db->getLastErrno()==1062){
														die(json_encode([
															'type'=>'warning',
															'msg'=>'این شماره اموال قبلا در سیستم ثبت شده',
															'err'=>0,
															'data'=>null
														]));
													}else{

														die(json_encode([
															'type'=>'warning',
															'msg'=>'مشکلی در انجام درخواست شما پیش آمده. با پشتیبان سایت تماس بگیرید و کد ('.$db->getLastErrno().') را اعلام نمایید',
															'err'=>-2,
															'data'=>null
														]));
													}
												}
											}
										case 'getData':
											if(isset($_POST['id']))
											{
												$_SESSION['DATA']['MechanizedScanning']['Equipments']['EDIT']['ID']=$_POST['id'];
												echo $db->where('id',$_POST['id'])->jsonBuilder()->getOne('Eq',[
													'type','size','company','propertyNumber','description','count'
												]);
											}
											break;
										case 'edit':
											if(!isset($_POST['Token']) || $_POST['Token']!=$_SESSION['Token']) die();
											if(isset($_POST['data']) && isset($_SESSION['DATA']['MechanizedScanning']['Equipments']['EDIT']['ID']))
											{
												$data=$_POST['data'];
												$validation=new Validation($data,[
													'name'=>['required[نام]','length[100,سایز,حداکثر]:max,100'],
													'brand'=>['length[برند,حداکثر,100]:max,100'],
													'propertyNumber'=>['required[شماره اموال]','max[شماره اموال,9999]:9999','min[شماره اموال,1]:1'],
													'accessories'=>'in[انتخاب,لوازم جانبی]:0,1',
													'description'=>['length[توضیحات,حداکثر,100]:max,100','length[توضیحات,حداقل,10]:min,10'],
													'count'=>['required[تعداد]','numeric[تعداد]'],
													'status'=>'in[انتخاب,وضعیت]:0,1'
												]);
												if($validation->getStatus()){
													die(json_encode([
														'type'=>'danger',
														'msg'=>$validation->getErrors(),
														'err'=>-1,
														'data'=>null
													]));
												}
												$check=$db->where('id',$_SESSION['DATA']['MechanizedScanning']['Equipments']['EDIT']['ID'])->
												update('Eq',$data,1);
												if($check)
												{
													die(json_encode([
														'type'=>'success',
														'msg'=>'تجهیزات با موفقیت ویرایش شد',
														'err'=>null,
														'data'=>null
													]));
												}else{
													if($db->getLastErrno()==1062)
													{
														die(json_encode([
															'type'=>'warning',
															'msg'=>'این شماره اموال قبلا در سیستم ثبت شده',
															'err'=>0,
															'data'=>null
														]));
													}else{

														die(json_encode([
															'type'=>'warning',
															'msg'=>'مشکلی در انجام درخواست شما پیش آمده. با پشتیبان سایت تماس بگیرید و کد ('.$db->getLastErrno().') را اعلام نمایید',
															'err'=>-2,
															'data'=>null
														]));
													}
												}
											}
											break;
									}
									break;
							}
							break;
					}
				}else{
					if(!isset($_POST['Token']) || $_POST['Token']!=$_SESSION['Token']) die();
					if(isset($_POST['data']))
					{
						$data=$_POST['data'];
						$validation=new Validation($data,[
							'username'=>'required[نام کاربری]',
							'password'=>'required[گذرواژه]'
						]);
						if($validation->getStatus())
						{
							die(json_encode([
								'type'=>'danger',
								'msg'=>$validation->getErrors(),
								'err'=>-1,
								'data'=>null
							]));
						}
						$data['password']=cryptPassword($data['password'],$data['username'],'HBAutomationAdminLogin');
						$account=$db->where('username',$data['username'])->where('password',$data['password'])->
						objectBuilder()->getOne('Admin',[
							'id','username'
						]);
						if(empty($account))
						{
							echo json_encode([
								'type'=>'danger',
								'msg'=>'نام کاربری و یا گذرواژه اشتباه است',
								'err'=>0,
								'data'=>null
							]);
							die();
						}else{
							$_SESSION['Admin']=[
								'id'=>$account->id,
								'username'=>$account->username,
								'password'=>$data['password'],
								'timeOut'=>time()
							];
							echo json_encode([
								'type'=>'success',
								'msg'=>'ورود با موفقیت انجام شد',
								'err'=>null,
								'data'=>null
							]);
						}
					}
				}
				break;
		}
		break;
}