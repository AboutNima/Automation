<?php
switch($urlPath[1])
{
	case 'account':
		switch($urlPath[2])
		{
			case 'admin':
				if(isset($_SESSION['Admin']))
				{
					switch($urlPath[3]){
						case 'stayOnline':
							$db->where('id',$_SESSION['Admin']['id'])->update('Admin',[
								'onlineFrom'=>time()
							],1);
							echo $db->count;
							break;
						case 'chatroom':
							switch($urlPath[4]){
								case 'getStatus':
									$data=$db->where('id',['NOT IN'=>[$_SESSION['Admin']['id']]])->
									orderBy('id','DESC')->objectBuilder()->get('Admin',null,[
										'id','online',
										"(SELECT COUNT(id) FROM ChatRoom WHERE receiverId={$_SESSION['Admin']['id']} AND senderId=Admin.id AND seen='0') as unread"
									]);
									foreach($data as &$item) $item->online=strtr($item->online,['0'=>'offline','1'=>'online','2'=>'away']);
									die(json_encode($data));
									break;
								case 'getNotification':
									$data=$db->where('receiverId',$_SESSION['Admin']['id'])->
									where('notification','0')->
									join('Admin','Admin.id=senderId')->
									orderBy('ChatRoom.id','DESC')->
									objectBuilder()->get('ChatRoom',null,[
										'Admin.id','avatar','text','file','ChatRoom.id as cId'
									]);
									$id=[];
									foreach($data as &$item){
										$id[]=$item->cId;
										$item->avatar=empty($item->avatar)?'public/construct/media/user.png':$item->avatar;
										$item->text=preg_replace("#<br />#"," ",$item->text);
									}
									if(!empty($id)){
										$db->where('id',$id,'IN')->update('ChatRoom',[
											'notification'=>'1'
										]);
									}
									die(json_encode($data));
									break;
								case 'loadChat':
									if(isset($_POST['id'])){
										$id=$_POST['id'];
										$data=$db->where('id',$id)->objectBuilder()->getOne('Admin',[
											'id','online','onlineFrom'
										]);
										if(!empty($data)){
											$_SESSION['DATA']['Chatroom']=[
												'ID'=>$id,
												'Token'=>$data->Token=strtoupper(md5(randomText(10).$id))
											];
											$data->online=strtr($data->online,['0'=>'offline','1'=>'online','2'=>'away']);
											if($data->online=='online') $data->onlineFrom='آنلاین';
											elseif(empty($data->onlineFrom)) $data->onlineFrom='نامشخص';
											else $data->onlineFrom=humanTiming($data->onlineFrom);
											die(json_encode($data));
										}
									}
									break;
								case 'getChatroomReady':
									if(isset($_POST['Token'])){
										if($_POST['Token']!==$_SESSION['DATA']['Chatroom']['Token']) die(false);
										$id=$_SESSION['DATA']['Chatroom']['ID'];
										$data=$db->where("(receiverId={$id} AND senderId={$_SESSION['Admin']['id']})")->
										orWhere("(receiverId={$_SESSION['Admin']['id']} AND senderId={$id})")->orderBy('id','DESC')->
										objectBuilder()->get('ChatRoom',75,[
											'id','senderId','text','seen',
											"UNIX_TIMESTAMP(createdAt) as createdAt"
										]);
										$data=array_reverse($data);
										if(!empty($data)){
											$db->where('receiverId',$_SESSION['Admin']['id'])->update('ChatRoom',[
												'seen'=>'1','notification'=>'1'
											]);
											foreach($data as &$item){
												$item->sender=$item->senderId==$_SESSION['Admin']['id']?true:false;
												unset($item->senderId);
												$item->humanTiming=date('h:iA',$item->createdAt);
											}
											unset($item);
											die(json_encode($data));
										}
									}
									break;
								case 'sendMessage':
									if(isset($_POST['text'])&&isset($_POST['Token'])){
										if($_POST['Token']!==$_SESSION['DATA']['Chatroom']['Token']) die(false);
										$id=$_SESSION['DATA']['Chatroom']['ID'];
										if(empty(trim($_POST['text']))) return false;
										$text=nl2br($_POST['text']);
										$id=$db->insert('ChatRoom',[
											'receiverId'=>$id,
											'senderId'=>$_SESSION['Admin']['id'],
											'text'=>$text,
										]);
										if(!empty($id)){
											die(json_encode([
												'id'=>$id,
												'text'=>$text,
												'seen'=>0,
												'humanTiming'=>date('h:iA',$time=time()),
												'createdAt'=>$time
											]));
										}
									}
									break;
								case 'getNewMessage':
									if(isset($_POST['Token'])){
										if($_POST['Token']!==$_SESSION['DATA']['Chatroom']['Token']) die(false);
										$id=$_SESSION['DATA']['Chatroom']['ID'];
										$data=$db->where('senderId',$id)->
										where('receiverId',$_SESSION['Admin']['id'])->
										where('seen','0')->
										orderBy('id','ASC')->
										objectBuilder()->get('ChatRoom',null,[
											'id','text',"UNIX_TIMESTAMP(createdAt) as createdAt"
										]);
										if(!empty($data)){
											$db->where('receiverId',$_SESSION['Admin']['id'])->
											update('ChatRoom',['seen'=>'1']);
											foreach($data as &$item) $item->humanTiming=date('h:iA',$item->createdAt);
											unset($item);
											die(json_encode($data));
										}
									}
									break;
								case 'checkSeen':
									if(isset($_POST['data'])&&isset($_POST['Token'])){
										if($_POST['Token']!==$_SESSION['DATA']['Chatroom']['Token']) die(false);
										$id=$_SESSION['DATA']['Chatroom']['ID'];
										$data=$_POST['data'];
										$data=$db->where('id',$data,'IN')->
										where('senderId',$_SESSION['Admin']['id'])->
										where('receiverId',$id)->
										where('seen','1')->get('ChatRoom',null,'id');
										$data=array_column($data,'id');
										die(json_encode($data));
									}
									break;
							}
							break;
						case 'mechanizedScanning':
							switch($urlPath[4]){
								case 'tools':
									switch($urlPath[5]){
										case 'add':
											if(!isset($_POST['Token'])||$_POST['Token']!=$_SESSION['Token']) die();
											if(isset($_POST['data'])){
												$data=$_POST['data'];
												$validation=new Validation($data,[
													'type'=>['required[دسته بندی]','in[انتخاب,دسته بندی]:'.implode(',',array_keys(ToolsType))],
													'size'=>['length[سایز,حداکثر,10]:max,10'],
													'company'=>['required[شرکت سازنده]','length[شرکت سازنده,حداکثر,100]:max,100'],
													'propertyNumber'=>['max[شماره اموال,9999]:9999','min[شماره اموال,1]:1'],
													'description'=>['length[توضیحات,حداکثر,255]:max,255','length[توضیحات,حداقل,10]:min,10'],
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
											break;
										case 'getData':
											if(isset($_POST['id'])){
												$_SESSION['DATA']['MechanizedScanning']['Tools']['EDIT']['ID']=$_POST['id'];
												echo $db->where('id',$_POST['id'])->jsonBuilder()->getOne('MST',[
													'type','size','company','propertyNumber','description','count'
												]);
											}
											break;
										case 'edit':
											if(!isset($_POST['Token'])||$_POST['Token']!=$_SESSION['Token']) die();
											if(isset($_POST['data'])&&isset($_SESSION['DATA']['MechanizedScanning']['Tools']['EDIT']['ID'])){
												$data=$_POST['data'];
												$validation=new Validation($data,[
													'type'=>['required[دسته بندی]','in[انتخاب,دسته بندی]:'.implode(',',array_keys(ToolsType))],
													'size'=>['length[سایز,حداکثر,10]:max,10'],
													'company'=>['required[شرکت سازنده]','length[شرکت سازنده,حداکثر,100]:max,100'],
													'propertyNumber'=>['max[شماره اموال,9999]:9999','min[شماره اموال,1]:1'],
													'description'=>['length[توضیحات,حداکثر,255]:max,255','length[توضیحات,حداقل,10]:min,10'],
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
												if($check){
													die(json_encode([
														'type'=>'success',
														'msg'=>'ابزار با موفقیت ویرایش شد',
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
											break;
										case 'addSub':
											if(!isset($_POST['Token'])||$_POST['Token']!=$_SESSION['Token']) die();
											if(isset($_POST['data'])&&isset($_SESSION['DATA']['MechanizedScanning']['Tools']['ID'])){
												$data=$_POST['data'];
												$validation=new Validation($data,[
													'size'=>['required[سایز]','length[سایز,حداکثر,10]:max,10'],
													'count'=>['required[موجودی]','numeric[موجودی]'],
													'description'=>['length[توضیحات,حداکثر,255]:max,255','length[توضیحات,حداقل,10]:min,10'],
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
											break;
										case 'getSubData':
											if(isset($_POST['id'])){
												$_SESSION['DATA']['MechanizedScanning']['Tools']['SUB']['EDIT']['ID']=$_POST['id'];
												echo $db->where('id',$_POST['id'])->jsonBuilder()->getOne('MST',[
													'size','company','description','count'
												]);
											}
											break;
										case 'editSub':
											if(!isset($_POST['Token'])||$_POST['Token']!=$_SESSION['Token']) die();
											if(isset($_POST['data'])&&isset($_SESSION['DATA']['MechanizedScanning']['Tools']['SUB']['EDIT']['ID'])){
												$data=$_POST['data'];
												$validation=new Validation($data,[
													'size'=>['required[سایز]','length[سایز,حداکثر,10]:max,10'],
													'count'=>['required[موجودی]','numeric[موجودی]'],
													'description'=>['length[توضیحات,حداکثر,255]:max,255','length[توضیحات,حداقل,10]:min,10'],
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
										case 'getScannedData':
											if(isset($_POST['code'])){
												$code=$_POST['code'];
												$data=$db->where('QRCode',$code)->objectBuilder()->getOne('MST',[
													'id','type','count'
												]);
												if(empty($data)){
													die(json_encode([
														'type'=>'danger',
														'msg'=>'موردی پیدا نشد',
														'err'=>0,
														'data'=>null
													]));
												}else{
													$data->type=strtr($data->type,ToolsType);
													$_SESSION['DATA']['MechanizedScanning']['Tools']['SCAN']=[
														'ID'=>$data->id,
														'COUNT'=>$data->count
													];
													$sub=$db->where('subId',$data->id)->get('MST',null,[
														'id','size',"MST.count-(SELECT COUNT(id) FROM MSTHistory WHERE subToolId=MST.id AND status='0') as count"
													]);
													if(!empty($sub)){
														$data=[$data,$sub];
														$_SESSION['DATA']['MechanizedScanning']['Tools']['SCAN']['SUB']=true;
													}
													die(json_encode([
														'err'=>null,
														'data'=>json_encode($data)
													]));
												}
											}
											break;
										case 'record':
											if(!isset($_POST['Token'])||$_POST['Token']!=$_SESSION['Token']) die();
											if(isset($_POST['data'])&&isset($_SESSION['DATA']['MechanizedScanning']['Tools']['SCAN']['ID'])){
												$data=$_POST['data'];
												$rules=[
													'studentId'=>[
														'required[انتخاب کارآموز]',
														'in[انتخاب,کارآموز]:0,1,2'
													],
													'count'=>['required[تعداد]','numeric[تعداد]','min[تعداد,1]:1'],
													'status'=>['required[وضعیت]','in[انتخاب,وضعیت]:0,1']
												];
												if(isset($_SESSION['DATA']['MechanizedScanning']['Tools']['SCAN']['SUB'])){
													$rules['subToolId']=[
														'required[ابزار های زیر مجموعه]',
														'in[انتخاب,ابزار های زیر مجموعه]:'.implode(',',array_column($db->where('subId',$_SESSION['DATA']['MechanizedScanning']['Tools']['SCAN']['ID'])->get('MST',null,'id'),'id'))
													];
												}else unset($data['subToolId']);
												$validation=new Validation($data,$rules);
												if($validation->getStatus()){
													die(json_encode([
														'type'=>'danger',
														'msg'=>$validation->getErrors(),
														'err'=>-1,
														'data'=>null
													]));
												}
												if($data['status']=='0'){
													if(isset($_SESSION['DATA']['MechanizedScanning']['Tools']['SCAN']['SUB'])) $db->where('subToolId',$data['subToolId']);
													$check=$db->where('toolId',$_SESSION['DATA']['MechanizedScanning']['Tools']['SCAN']['ID'])->
													where('status','0')->getValue('MSTHistory','COUNT(id)');
													$toolCount=isset($_SESSION['DATA']['MechanizedScanning']['Tools']['SCAN']['SUB'])?$db->where('id',$data['subToolId'])->getOne('MST','count')['count']:$_SESSION['DATA']['MechanizedScanning']['Tools']['SCAN']['COUNT'];
													if($toolCount-$check>=$data['count']){
														for($i=0;$i<$data['count'];$i++) $id=$db->insert('MSTHistory',[
															'studentId'=>$data['studentId'],
															'subToolId'=>isset($_SESSION['DATA']['MechanizedScanning']['Tools']['SCAN']['SUB'])?$data['subToolId']:null,
															'status'=>$data['status'],
															'toolId'=>$_SESSION['DATA']['MechanizedScanning']['Tools']['SCAN']['ID']
														]);
														if((bool)$id){
															die(json_encode([
																'type'=>'success',
																'msg'=>'درخواست شما با موفقیت انجام شد',
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
													}else{
														die(json_encode([
															'type'=>'danger',
															'msg'=>'موجودی انبار کمتر از میزان درخواست شما میباشد',
															'err'=>0,
															'data'=>null
														]));
													}
												}else{
													if(isset($_SESSION['DATA']['MechanizedScanning']['Tools']['SCAN']['SUB'])) $db->where('subToolId',$data['subToolId']);
													$check=$db->where('studentId',$data['studentId'])->where('toolId',$_SESSION['DATA']['MechanizedScanning']['Tools']['SCAN']['ID'])->
													where('status','0')->update('MSTHistory',['status'=>'1'],$data['count']);
													if($db->count>0){
														die(json_encode([
															'type'=>'success',
															'msg'=>'تعداد '.$db->count.' ابزار تحویل گرفته شد',
															'err'=>null,
															'data'=>null
														]));
													}else{
														die(json_encode([
															'type'=>'warning',
															'msg'=>'موردی جهت بازگشت به انبار یافت نشد',
															'err'=>1,
															'data'=>null
														]));
													}
												}
											}
											break;
									}
									break;
								case 'equipments':
									switch($urlPath[5]){
										case 'add':
											if(!isset($_POST['Token'])||$_POST['Token']!=$_SESSION['Token']) die();
											if(isset($_POST['data'])){
												$data=$_POST['data'];
												$data['accessories']=isset($data['accessories'])?'1':'0';
												$validation=new Validation($data,[
													'title'=>['required[نام]','length[100,سایز,حداکثر]:max,100'],
													'company'=>['length[شرکت سازنده,حداکثر,100]:max,100'],
													'propertyNumber'=>['required[شماره اموال]','max[شماره اموال,9999]:9999','min[شماره اموال,1]:1'],
													'accessories'=>'in[انتخاب,لوازم جانبی]:0,1',
													'description'=>['length[توضیحات,حداکثر,255]:max,255','length[توضیحات,حداقل,10]:min,10'],
													'count'=>['required[تعداد]','numeric[تعداد]'],
													'status'=>['required[وضعیت]','in[انتخاب,وضعیت]:0,1,2']
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
												$id=$db->insert('MSE',$data);
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
											if(isset($_POST['id'])){
												$_SESSION['DATA']['MechanizedScanning']['Equipments']['EDIT']['ID']=$_POST['id'];
												echo $db->where('id',$_POST['id'])->jsonBuilder()->getOne('MSE',[
													'title','company','propertyNumber','accessories','count','status','description'
												]);
											}
											break;
										case 'edit':
											if(!isset($_POST['Token'])||$_POST['Token']!=$_SESSION['Token']) die();
											if(isset($_POST['data'])&&isset($_SESSION['DATA']['MechanizedScanning']['Equipments']['EDIT']['ID'])){
												$data=$_POST['data'];
												$data['accessories']=isset($data['accessories'])?'1':'0';
												$validation=new Validation($data,[
													'title'=>['required[نام]','length[100,سایز,حداکثر]:max,100'],
													'company'=>['length[شرکت سازنده,حداکثر,100]:max,100'],
													'propertyNumber'=>['required[شماره اموال]','max[شماره اموال,9999]:9999','min[شماره اموال,1]:1'],
													'accessories'=>'in[انتخاب,لوازم جانبی]:0,1',
													'description'=>['length[توضیحات,حداکثر,255]:max,255','length[توضیحات,حداقل,10]:min,10'],
													'count'=>['required[تعداد]','numeric[تعداد]'],
													'status'=>['required[وضعیت]','in[انتخاب,وضعیت]:0,1,2']
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
												update('MSE',$data,1);
												if($check){
													die(json_encode([
														'type'=>'success',
														'msg'=>'تجهیزات با موفقیت ویرایش شد',
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
											break;
										case 'getScannedData':
											if(isset($_POST['code'])){
												$code=$_POST['code'];
												$data=$db->where('QRCode',$code)->objectBuilder()->getOne('MSE',[
													'id','title','count'
												]);
												if(empty($data)){
													die(json_encode([
														'type'=>'danger',
														'msg'=>'موردی پیدا نشد',
														'err'=>0,
														'data'=>null
													]));
												}else{
													$_SESSION['DATA']['MechanizedScanning']['Equipments']['SCAN']=[
														'ID'=>$data->id,
														'COUNT'=>$data->count
													];
													die(json_encode([
														'err'=>null,
														'data'=>json_encode($data)
													]));
												}
											}
											break;
										case 'record':
											if(!isset($_POST['Token'])||$_POST['Token']!=$_SESSION['Token']) die();
											if(isset($_POST['data'])&&isset($_SESSION['DATA']['MechanizedScanning']['Equipments']['SCAN']['ID'])){
												$data=$_POST['data'];
												$validation=new Validation($data,[
													'studentId'=>[
														'required[انتخاب کارآموز]',
														'in[انتخاب,کارآموز]:0,1,2'
													],
													'count'=>['required[تعداد]','numeric[تعداد]','min[تعداد,1]:1'],
													'status'=>['required[وضعیت]','in[انتخاب,وضعیت]:0,1']
												]);
												if($validation->getStatus()){
													die(json_encode([
														'type'=>'danger',
														'msg'=>$validation->getErrors(),
														'err'=>-1,
														'data'=>null
													]));
												}
												if($data['status']=='0'){
													$check=$db->where('toolId',$_SESSION['DATA']['MechanizedScanning']['Equipments']['SCAN']['ID'])->
													where('status','0')->getValue('MSEHistory','COUNT(id)');
													if($_SESSION['DATA']['MechanizedScanning']['Equipments']['SCAN']['COUNT']-$check>=$data['count']){
														for($i=0;$i<$data['count'];$i++) $id=$db->insert('MSEHistory',[
															'studentId'=>$data['studentId'],
															'status'=>$data['status'],
															'toolId'=>$_SESSION['DATA']['MechanizedScanning']['Equipments']['SCAN']['ID']
														]);
														if((bool)$id){
															die(json_encode([
																'type'=>'success',
																'msg'=>'درخواست شما با موفقیت انجام شد',
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
													}else{
														die(json_encode([
															'type'=>'danger',
															'msg'=>'موجودی انبار کمتر از میزان درخواست شما میباشد',
															'err'=>0,
															'data'=>null
														]));
													}
												}else{
													$check=$db->where('studentId',$data['studentId'])->where('toolId',$_SESSION['DATA']['MechanizedScanning']['Equipments']['SCAN']['ID'])->
													where('status','0')->update('MSEHistory',['status'=>'1'],$data['count']);
													if($db->count>0){
														die(json_encode([
															'type'=>'success',
															'msg'=>'تعداد '.$db->count.' ابزار تحویل گرفته شد',
															'err'=>null,
															'data'=>null
														]));
													}else{
														die(json_encode([
															'type'=>'warning',
															'msg'=>'موردی جهت بازگشت به انبار یافت نشد',
															'err'=>1,
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
						case 'students':
							switch($urlPath[4]){
								case 'add':
									if(!isset($_POST['Token'])||$_POST['Token']!=$_SESSION['Token']) die();
									if(isset($_POST['data'])){
										$data=$_POST['data'];
										@$data['birthDay']=convertToGregorian($data['birthDay']);
										$validation=new Validation($data,[
											'name'=>['required[نام]','length[نام,حداکثر,70]:max,70'],
											'surname'=>['required[نام خانوادگی]','length[نام خانوادگی,حداکثر,70]:max,70'],
											'name_en'=>['required[نام (انگلیسی)]','length[نام (انگلیسی),حداکثر,70]:max,70','EnglishCharacters[نام (انگلیسی)]'],
											'surname_en'=>['required[نام خانوادگی (انگلیسی)]','length[نام خانوادگی (انگلیسی),حداکثر,70]:max,70','EnglishCharacters[نام خانوادگی (انگلیسی)]'],
											'fatherName'=>['required[نام پدر]','length[نام پدر,حداکثر,70]:max,70'],
											'nationalCode'=>['required[کد ملی]','NationalCode'],
											'birthCNumber'=>['required[شماره شناسنامه]','Numeric[شماره شناسنامه]','length[شماره شناسنامه,حداکثر,10]:max,10'],
											'phoneNumber'=>['required[شماره همراه]','PhoneNumber'],
											'homeNumber'=>'HomeNumber',
											'birthDay'=>['required[تاریخ تولد]','date[تاریخ تولد]'],
											'education'=>['required[میزان تحصیلات]','in[انتخاب,میزان تحصیلات]:0,1,2,3,4,5,6'],
											'address'=>['required[آدرس]','length[آدرس,حداکثر,250]:max,250'],
											'job'=>'length[شغل,حداکثر,75]:max,75'
										]);
										if($validation->getStatus()){
											die(json_encode([
												'type'=>'danger',
												'msg'=>$validation->getErrors(),
												'err'=>-1,
												'data'=>null
											]));
										}
										if(empty($data['homeNumber'])) $data['homeNumber']=null;
										if(empty($data['job'])) $data['job']=null;
										$data['QRCode']=randomText(25);
										$id=$db->insert('Students',$data);
										if((bool)$id){
											die(json_encode([
												'type'=>'success',
												'msg'=>'کارآموز جدید با موفقیت ثبت شد',
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
								case 'getData':
									if(isset($_POST['id'])){
										$_SESSION['DATA']['Students']['EDIT']['ID']=$_POST['id'];
										echo $db->where('id',$_POST['id'])->jsonBuilder()->getOne('Students',[
											'name','surname','name_en','surname_en','fatherName','nationalCode',
											'birthCNumber','phoneNumber','homeNumber','birthDay','education','address','job'
										]);
									}
									break;
								case 'edit':
									if(!isset($_POST['Token'])||$_POST['Token']!=$_SESSION['Token']) die();
									if(isset($_POST['data'])&&isset($_SESSION['DATA']['Students']['EDIT']['ID'])){
										$data=$_POST['data'];
										@$data['birthDay']=convertToGregorian($data['birthDay']);
										$validation=new Validation($data,[
											'name'=>['required[نام]','length[نام,حداکثر,70]:max,70'],
											'surname'=>['required[نام خانوادگی]','length[نام خانوادگی,حداکثر,70]:max,70'],
											'name_en'=>['required[نام (انگلیسی)]','length[نام (انگلیسی),حداکثر,70]:max,70','EnglishCharacters[نام (انگلیسی)]'],
											'surname_en'=>['required[نام خانوادگی (انگلیسی)]','length[نام خانوادگی (انگلیسی),حداکثر,70]:max,70','EnglishCharacters[نام خانوادگی (انگلیسی)]'],
											'fatherName'=>['required[نام پدر]','length[نام پدر,حداکثر,70]:max,70'],
											'nationalCode'=>['required[کد ملی]','NationalCode'],
											'birthCNumber'=>['required[شماره شناسنامه]','Numeric[شماره شناسنامه]','length[شماره شناسنامه,حداکثر,10]:max,10'],
											'phoneNumber'=>['required[شماره همراه]','PhoneNumber'],
											'homeNumber'=>'HomeNumber',
											'birthDay'=>['required[تاریخ تولد]','date[تاریخ تولد]'],
											'education'=>['required[میزان تحصیلات]','in[انتخاب,میزان تحصیلات]:0,1,2,3,4,5,6'],
											'address'=>['required[آدرس]','length[آدرس,حداکثر,250]:max,250'],
											'job'=>'length[شقل,حداکثر,75]:max,75'
										]);
										if($validation->getStatus()){
											die(json_encode([
												'type'=>'danger',
												'msg'=>$validation->getErrors(),
												'err'=>-1,
												'data'=>null
											]));
										}
										$check=$db->where('id',$_SESSION['DATA']['Students']['EDIT']['ID'])->
										update('Students',$data,1);
										if($check){
											die(json_encode([
												'type'=>'success',
												'msg'=>'کارآموز با موفقیت ویرایش شد',
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
						case 'setting':
							switch($urlPath[4]){
								case 'changePassword':
									if(!isset($_POST['Token'])||$_POST['Token']!=$_SESSION['Token']) die();
									if(isset($_POST['data'])){
										$data=$_POST['data'];
										$validation=new Validation($data,[
											'new'=>['required[گذرواژه جدید]','length[گذرواژه جدید,حداکثر,50]:max,50','same[گذرواژه جدید,تکرار گذرواژه جدید]:repeat'],
											'repeat'=>['required[تکرار گذرواژه جدید]','length[تکرار گذرواژه جدید,حداکثر,50]:max,50'],
											'yet'=>['required[گذرواژه فعلی]','length[گذرواژه فعلی,حداکثر,50]:max,50'],
										]);
										if($validation->getStatus()){
											die(json_encode([
												'type'=>'danger',
												'msg'=>$validation->getErrors(),
												'err'=>-1,
												'data'=>null
											]));
										}
										$check=(int)$db->where('id',$_SESSION['Admin']['id'])->
										where('password',cryptPassword($data['yet'],$_SESSION['Admin']['username'],'HBAutomationAdminLogin'))->
										getOne('Admin','id')['id'];
										if($check!==0){
											$check=$db->where('id',$_SESSION['Admin']['id'])->update('Admin',[
												'password'=>$password=cryptPassword($data['new'],$_SESSION['Admin']['username'],'HBAutomationAdminLogin')
											]);
											if($check){
												$_SESSION['Admin']['password']=$password;
												die(json_encode([
													'type'=>'success',
													'msg'=>'گذرواژه با موفقیت ویرایش شد',
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
										}else{
											die(json_encode([
												'type'=>'danger',
												'msg'=>'گذرواژه فعلی اشتباه است',
												'err'=>0,
												'data'=>null
											]));
										}
									}
									break;
								case 'profile':
									if(!isset($_POST['Token'])||$_POST['Token']!=$_SESSION['Token']) die();
									if(isset($_POST['data'])){
										$data=$_POST['data'];
										$data['avatar']=isset($_FILES['file'])?$_FILES['file']:'';
										$validation=new Validation($data,[
											'name'=>['required[نام]','length[نام,حداکثر,75]:max,75'],
											'surname'=>['required[نام خانوادگی]','length[نام خانوادگی,حداکثر,75]:max,75'],
											'nationalCode'=>['required[کد ملی]','nationalCode'],
											'phoneNumber'=>['required[شماره همراه]','phoneNumber'],
											'avatar'=>['upload[jpg.jpeg.png.tiff,512]:png.jpg.jpeg.tiff,512']
										]);
										if($validation->getStatus()){
											die(json_encode([
												'type'=>'danger',
												'msg'=>$validation->getErrors(),
												'err'=>-1,
												'data'=>null
											]));
										}
										if(!empty($data['avatar'])){
											$upload=new \Verot\Upload\Upload($data['avatar']);
											if($upload->uploaded){
												$upload->file_new_name_body=sha1(randomCode(10));
												$upload->image_resize=true;
												$upload->image_x=250;
												$upload->image_y=250;
												$upload->process('public/account/admin/media/'.$_SESSION['Admin']['id'].'/avatar');
												if($upload->processed) $data['avatar']=str_replace('\\','/',$upload->file_dst_pathname);
											}
										}else unset($data['avatar']);
										$check=$db->where('id',$_SESSION['Admin']['id'])->update('Admin',$data);
										if($check){
											if(!empty($_SESSION['Admin']['avatar'])&&isset($data['avatar'])) unlink($_SESSION['Admin']['avatar']);
											die(json_encode([
												'type'=>'success',
												'msg'=>'اطلاعات حساب مدیریت شما با موفقیت ویرایش شد',
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
						case 'consumingMaterials':
							switch($urlPath[4]){
								case 'add':
									if(!isset($_POST['Token'])||$_POST['Token']!=$_SESSION['Token']) die();
									if(isset($_POST['data'])){
										$data=$_POST['data'];
										$validation=new Validation($data,[
											'title'=>['required[نام]','length[نام,حداکثر,100]:max,100'],
											'company'=>'length[شرکت سازنده,حداکثر,100]:max,100',
											'propertyNumber'=>['required[شماره اموال]','max[شماره اموال,9999]:9999','min[شماره اموال,1]:1'],
											'unit'=>['required[واحد شمارش]','in[انتخاب,واحد شمارش]:0,1,2,3'],
											'count'=>['required[تعداد]','numeric[تعداد]'],
											'description'=>['length[حداکثر,توضیحات,100]:max,100','length[حداقل,توضیحات,10]:min,10']
										]);
										if($validation->getStatus()){
											die(json_encode([
												'type'=>'danger',
												'msg'=>$validation->getErrors(),
												'err'=>-1,
												'data'=>null
											]));
										}
										if(empty($data['company'])) $data['company']=null;
										if(empty($data['description'])) $data['description']=null;
										$id=$db->insert('CMaterials',$data);
										if((bool)$id){
											die(json_encode([
												'type'=>'success',
												'msg'=>'مواد جدید با موفقیت ثبت شد',
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
									break;
								case 'getData':
									if(isset($_POST['id'])){
										$_SESSION['DATA']['CMaterials']['EDIT']['ID']=$_POST['id'];
										echo $db->where('id',$_POST['id'])->jsonBuilder()->getOne('CMaterials',[
											'id','title','propertyNumber','company','unit','count','description',
											'(SELECT SUM(changeRate) FROM CMHistory WHERE changeRate<0 AND CMId='.$_POST['id'].') as countUsed'
										]);
									}
									break;
								case 'edit':
									if(!isset($_POST['Token'])||$_POST['Token']!=$_SESSION['Token']) die();
									if(isset($_POST['data']) && isset($_SESSION['DATA']['CMaterials']['EDIT']['ID'])){
										$data=$_POST['data'];
										$validation=new Validation($data,[
											'title'=>['required[نام]','length[نام,حداکثر,100]:max,100'],
											'company'=>'length[شرکت سازنده,حداکثر,100]:max,100',
											'propertyNumber'=>['required[شماره اموال]','max[شماره اموال,9999]:9999','min[شماره اموال,1]:1'],
											'unit'=>['required[واحد شمارش]','in[انتخاب,واحد شمارش]:0,1,2,3'],
											'count'=>['required[تعداد]','numeric[تعداد]'],
											'description'=>['length[حداکثر,توضیحات,100]:max,100','length[حداقل,توضیحات,10]:min,10']
										]);
										if($validation->getStatus()){
											die(json_encode([
												'type'=>'danger',
												'msg'=>$validation->getErrors(),
												'err'=>-1,
												'data'=>null
											]));
										}
										$check=$db->where('id',$_SESSION['DATA']['CMaterials']['EDIT']['ID'])->
										update('CMaterials',$data,1);
										if($check){
											die(json_encode([
												'type'=>'success',
												'msg'=>'مواد با موفقیت ویرایش شد',
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
									break;
								case 'delete':
									if(!isset($_POST['Token']) || $_POST['Token']!=$_SESSION['Token']) die();
									if(isset($_POST['id'])){
										$check=$db->where('id',$_POST['id'])->delete('CMaterials',null);
										if($check){
											die(json_encode([
												'type'=>'success',
												'msg'=>'مواد با موفقیت حذف شد',
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
								case 'changeRate':
									if(!isset($_POST['Token']) || $_POST['Token']!=$_SESSION['Token']) die();
									if(isset($_POST['data']) && isset($_SESSION['DATA']['CMaterials']['EDIT']['ID']))
									{
										$data=$_POST['data'];
										$studentId=$data['studentId'];
										$description=$data['description'];
										if($data['type']=='0'){
											$changeRate=$data['changeRate'];
											$validation=new Validation($data,[
												'type'=>['required[نوع تغییرات]','in[انتخاب,میزان تغییرات]:0,1'],
												'changeRate'=>['required[میزان تغییرات]','numeric[میزان تغییرات]','min[میزان تغییرات,1]:1'],
												'count'=>['required[موجودی فعلی]','numeric[موجودی فعلی]'],
												'studentId'=>['required[تغییر موجودی توسط]','in[انتخاب,تغیر موجودی توسط]:0,'.implode(',',$_SESSION['DATA']['CMaterials']['ChangeRate']['ID'])],
												'description'=>['required[توضیحات]','length[حداکثر,توضیحات,100]:max,100','length[حداقل,توضیحات,10]:min,10']
											]);
										}else{
											$changeRate=-1*$data['changeRate'];
											$validation=new Validation($data,[
												'type'=>['required[نوع تغییرات]','in[انتخاب,میزان تغییرات]:0,1'],
												'changeRate'=>['required[میزان تغییرات]','numeric[میزان تغییرات]','max[میزان تغییرات,موجودی]:'.$data['count']],
												'count'=>['required[موجودی فعلی]','numeric[موجودی فعلی]'],
												'studentId'=>['required[تغییر موجودی توسط]','in[انتخاب,تغیر موجودی توسط]:0,'.implode(',',$_SESSION['DATA']['CMaterials']['ChangeRate']['ID'])],
												'description'=>['required[توضیحات]','length[حداکثر,توضیحات,100]:max,100','length[حداقل,توضیحات,10]:min,10']
											]);
										}
										if($validation->getStatus()){
											die(json_encode([
												'type'=>'danger',
												'msg'=>$validation->getErrors(),
												'err'=>-1,
												'data'=>null
											]));
										}
										$data=$data['type']=='0' ? ['count'=>$data['count']+$data['changeRate']] : ['count'=>$data['count']-$data['changeRate']];
										$check=$db->where('id',$_SESSION['DATA']['CMaterials']['EDIT']['ID'])->
										update('CMaterials',$data,1);
										if($check){
											$data=[
												'CMId'=>$_SESSION['DATA']['CMaterials']['EDIT']['ID'],
												'changeRate'=>$changeRate,
												'studentId'=>$studentId,
												'description'=>$description
											];
											$check=$db->insert('CMHistory',$data);
											die(json_encode([
												'type'=>'success',
												'msg'=>'موجودی با موفقیت تغییر کرد',
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
						case 'accounting':
							switch($urlPath[4])
							{
								case 'title':
									switch($urlPath[5])
									{
										case 'add':
											if(!isset($_POST['Token'])||$_POST['Token']!=$_SESSION['Token']) die();
											if(isset($_POST['data']))
											{
												$data=$_POST['data'];
												$validation=new Validation($data,[
													'title'=>['required[عنوان]','length[عنوان,حداکثر,100]:max,100'],
												]);
												if($validation->getStatus()){
													die(json_encode([
														'type'=>'danger',
														'msg'=>$validation->getErrors(),
														'err'=>-1,
														'data'=>null
													]));
												}
												$id=$db->insert('ACCTitles',$data);
												if((bool)$id){
													die(json_encode([
														'type'=>'success',
														'msg'=>'سرفصل جدید با موفقیت ایجاد شد',
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
										case 'getData':
											if(isset($_POST['id'])){
												$_SESSION['DATA']['Accounting']['Title']['EDIT']['ID']=$_POST['id'];
												echo $db->where('id',$_POST['id'])->jsonBuilder()->getOne('ACCTitles',[
													'title'
												]);
											}
											break;
										case 'edit':
											if(!isset($_POST['Token'])||$_POST['Token']!=$_SESSION['Token']) die();
											if(isset($_POST['data']) && isset($_SESSION['DATA']['Accounting']['Title']['EDIT']['ID']))
											{
												$data=$_POST['data'];
												$validation=new Validation($data,[
													'title'=>['required[عنوان]','length[عنوان,حداکثر,100]:max,100'],
												]);
												if($validation->getStatus()){
													die(json_encode([
														'type'=>'danger',
														'msg'=>$validation->getErrors(),
														'err'=>-1,
														'data'=>null
													]));
												}
												$check=$db->where('id',$_SESSION['DATA']['Accounting']['Title']['EDIT']['ID'])->
												update('ACCTitles',$data,1);
												if($check){
													die(json_encode([
														'type'=>'success',
														'msg'=>'سرفصل با موفقیت ویرایش شد',
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
								case 'costIncome':
									switch($urlPath[5])
									{
										case 'add':
											if(!isset($_POST['Token'])||$_POST['Token']!=$_SESSION['Token']) die();
											if(isset($_POST['data']))
											{
												$data=$_POST['data'];
												$data['price']=str_replace(',','',$data['price']);
												$validation=new Validation($data,[
													'subject'=>['required[موضوع]','length[موضوع,حداکثر,100]:max,100'],
													'titleId'=>[
														'required[سرفصل]',
														'in[انتخاب,سرفصل]:'.implode(',',array_column($db->get('ACCTitles',null,'id'),'id'))
													],
													'price'=>['required[مبلغ]','numeric[مبلغ]'],
													'income'=>['required[نوع]','in[انتخاب,نوع]:0,1'],
													'description'=>['required[توضیحات]','length[توضیحات,حداکثر,65535]:max,65535'],
												]);
												if($validation->getStatus()){
													die(json_encode([
														'type'=>'danger',
														'msg'=>$validation->getErrors(),
														'err'=>-1,
														'data'=>null
													]));
												}
												$id=$db->insert('ACCCostIncome',$data);
												if((bool)$id){
													die(json_encode([
														'type'=>'success',
														'msg'=>'مورد جدید با موفقیت ثبت شد',
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
										case 'getData':
											if(isset($_POST['id'])){
												$_SESSION['DATA']['Accounting']['CostIncome']['EDIT']['ID']=$_POST['id'];
												echo $db->where('id',$_POST['id'])->jsonBuilder()->getOne('ACCCostIncome',[
													'titleId','subject','price','income','description'
												]);
											}
											break;
										case 'edit':
											if(!isset($_POST['Token'])||$_POST['Token']!=$_SESSION['Token']) die();
											if(isset($_POST['data']) && isset($_SESSION['DATA']['Accounting']['CostIncome']['EDIT']['ID']))
											{
												$data=$_POST['data'];
												$data['price']=str_replace(',','',$data['price']);
												$validation=new Validation($data,[
													'subject'=>['required[موضوع]','length[موضوع,حداکثر,100]:max,100'],
													'titleId'=>[
														'required[سرفصل]',
														'in[انتخاب,سرفصل]:'.implode(',',array_column($db->get('ACCTitles',null,'id'),'id'))
													],
													'price'=>['required[مبلغ]','numeric[مبلغ]'],
													'income'=>['required[نوع]','in[انتخاب,نوع]:0,1'],
													'description'=>['required[توضیحات]','length[توضیحات,حداکثر,65535]:max,65535'],
												]);
												if($validation->getStatus()){
													die(json_encode([
														'type'=>'danger',
														'msg'=>$validation->getErrors(),
														'err'=>-1,
														'data'=>null
													]));
												}
												$check=$db->where('id',$_SESSION['DATA']['Accounting']['CostIncome']['EDIT']['ID'])->
												update('ACCCostIncome',$data,1);
												if($check){
													die(json_encode([
														'type'=>'success',
														'msg'=>'درخواست شما با موفقیت انجام شد',
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
										case 'remove':
											if(isset($_POST['id'])){
												$check=$db->where('id',$_POST['id'])->delete('ACCCostIncome',1);
												if($check){
													die(json_encode([
														'type'=>'success',
														'msg'=>'درخواست شما با موفقیت انجام شد',
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
							}
							break;
						default:
							if($_SESSION['Admin']['id']==1){
								switch($urlPath[3]){
									case 'manageAdmins':
										switch($urlPath[4]){
											case 'add':
												if(!isset($_POST['Token'])||$_POST['Token']!=$_SESSION['Token']) die();
												if(isset($_POST['data'])){
													$data=$_POST['data'];
													$validation=new Validation($data,[
														'name'=>['required[نام]','length[نام,حداکثر,70]:max,70'],
														'surname'=>['required[نام خانوادگی]','length[نام خانوادگی,حداکثر,70]:max,70'],
														'nationalCode'=>['required[کد ملی]','NationalCode'],
														'phoneNumber'=>['required[شماره همراه]','PhoneNumber'],
														'username'=>['required[نام کاربری]','usernameCharacter','length[نام کاربری ,حداکثر,25]:max,25','length[نام کاربری ,حداقل,3]:min,3']
													]);
													if($validation->getStatus()){
														die(json_encode([
															'type'=>'danger',
															'msg'=>$validation->getErrors(),
															'err'=>-1,
															'data'=>null
														]));
													}
													$data['password']=cryptPassword($data['username'],$data['username'],'HBAutomationAdminLogin');
													$id=$db->insert('Admin',$data);
													if((bool)$id){
														die(json_encode([
															'type'=>'success',
															'msg'=>'حساب مدیریت جدید با موفقیت ثبت شد',
															'err'=>null,
															'data'=>null
														]));
													}else{
														if($db->getLastErrno()==1062){
															die(json_encode([
																'type'=>'warning',
																'msg'=>'این کد ملی قبلا در سیستم ثبت شده',
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
											case 'resetPassword':
												if(isset($_POST['id'])){
													$data=$db->where('id',$_POST['id'])->getOne('Admin','username')['username'];
													$check=$db->where('id',$_POST['id'])->update('Admin',[
														'password'=>cryptPassword($data,$data,'HBAutomationAdminLogin')
													]);
													if($check){
														die(json_encode([
															'type'=>'success',
															'msg'=>'گذرواژه با موفقیت بازنشانی شد',
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
								}
							}
							break;
					}
				}else{
					if(!isset($_POST['Token'])||$_POST['Token']!=$_SESSION['Token']) die();
					if(isset($_POST['data'])){
						$data=$_POST['data'];
						$validation=new Validation($data,[
							'username'=>'required[نام کاربری]',
							'password'=>'required[گذرواژه]'
						]);
						if($validation->getStatus()){
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
						if(empty($account)){
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