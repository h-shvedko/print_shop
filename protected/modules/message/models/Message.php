<?php

/**
 * This is the model class for table "message".
 *
 * The followings are the available columns in table 'message':
 * @property integer $id
 * @property integer $users__id
 * @property string $email_to
 * @property string $subject
 * @property string $body
 * @property string $date_send
 * @property integer $type__id
 */
class Message extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'message';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email_to, subject, body, date_send, type__id', 'required'),
			array('users__id, type__id', 'numerical', 'integerOnly'=>true),
			array('email_to', 'length', 'max'=>50),
			array('subject', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, users__id, email_to, subject, body, date_send, type__id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'messageType' => array(self::BELONGS_TO, 'MessageType', 'type__id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'users__id' => 'Users',
			'email_to' => 'Email To',
			'subject' => 'Subject',
			'body' => 'Body',
			'date_send' => 'Date Send',
			'type__id' => 'Type',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('users__id',$this->users__id);
		$criteria->compare('email_to',$this->email_to,true);
		$criteria->compare('subject',$this->subject,true);
		$criteria->compare('body',$this->body,true);
		$criteria->compare('date_send',$this->date_send,true);
		$criteria->compare('type__id',$this->type__id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Message the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public static function sendMessage($model, $isAdmin = FALSE)
	{
		Yii::import('application.extensions.phpmailer.JPhpMailer');
		$mail = new JPhpMailer;
		$mail->IsSMTP();
		$mail->Host = Yii::app()->params['host'];
		$mail->SMTPSecure = Yii::app()->params['encryption'];
		$mail->Port = Yii::app()->params['port'];
		$mail->SMTPAuth = Yii::app()->params['smtpauth'];
		$mail->Username = Yii::app()->params['username'];
		$mail->Password = Yii::app()->params['password'];
		$mail->SetFrom(Yii::app()->params['username'], Yii::app()->name);
		
		if($isAdmin)
		{
			$mail->Subject = self::getSubject($model, TRUE);
		}
		else
		{
			$mail->Subject = self::getSubject($model);
		}
		if($isAdmin)
		{
			$mail->MsgHTML(self::getMessage($model, TRUE));
		}
		else
		{
			$mail->MsgHTML(self::getMessage($model));
		}
		
		if($isAdmin)
		{
			$mail->AddAddress(Yii::app()->params['username'], Profile::getFullName($model->users__id));
		}
		else
		{
			$mail->AddAddress($model->email, Profile::getFullName($model->users__id));
		}
		
		$mail->Send();
	}
	
	public static function getArrayFromModel($model, $type)
	{
		$value = array();
		
		if($type->alias == MessageType::ORDER)
		{
			$value['type__id'] = $type->id;
			$value['users__id'] = $model->users__id;
			$value['email_to'] = $model->email;
			$value['subject_admin'] = self::getSubject($model, TRUE);
			$value['body_admin'] = self::getMessage($model, TRUE);
			$value['subject'] = self::getSubject($model);
			$value['body'] = self::getMessage($model);
						
			return $value;
			
			
		}
		if($type->alias == MessageType::REGISTER)
		{
			$value['type__id'] = $type->id;
			$value['users__id'] = $model->users__id;
			$value['email_to'] = $model->email;
			$value['subject'] = self::getSubject($model);
			$value['body'] = self::getMessage($model);
			$value['subject_admin'] = self::getSubject($model, TRUE);
			$value['body_admin'] = self::getMessage($model, TRUE);
			
			return $value;
			
		}
		if($type->alias == MessageType::OTHER)
		{
			/*$value['type__id'] = $type->id;
			$value['users__id'] = $model->users__id;
			$value['email_to'] = $model->email;
			$value['subject'] = self::getSubjectForRegisterClient($model);
			$value['body'] = self::setMessageOfRegisterForClient($model);*/
			return $value;
			
		}
	}
	
	public function addMessage($model, $type)
	{
		$typeModel = MessageType::model()->findByAlias($type);
		
		$value = self::getArrayFromModel($model, $typeModel);
		
		$message = new Message();
		$message->users__id = $value['users__id'];
		$message->email_to = $value['email_to'];
		$message->subject = $value['subject'];
		$message->body = $value['body'];
		$message->date_send = date("Y-m-d H:m:i");
		$message->type__id = $value['type__id'];
	
		if(!$message->save())
		{
			$message->validate();
			var_dump($message->getErrors());
			throw new CException('ошибка отправки сообщения', E_USER_ERROR);
		}
		self::sendMessage($model, FALSE);
		
		if($type == MessageType::ORDER || $type == MessageType::REGISTER)
		{
			$valueAdmin = self::getArrayFromModel($model, $typeModel);
			
			$messageAdmin = new Message();
			$messageAdmin->users__id = '-1';
			$messageAdmin->email_to = Yii::app()->params['adminEmail'];
			$messageAdmin->subject = $valueAdmin['subject_admin'];
			$messageAdmin->body = $valueAdmin['body_admin'];
			$messageAdmin->date_send = date("Y-m-d H:m:i");
			$messageAdmin->type__id = $valueAdmin['type__id'];
		
			if(!$messageAdmin->save())
			{
				$messageAdmin->validate();
				var_dump($messageAdmin->getErrors());
				throw new CException('ошибка отправки сообщения для админа', E_USER_ERROR);
			}
			self::sendMessage($model, TRUE);
		}
		
		return TRUE;
	}
			
	public static function getSubject($model, $isAdmin = FALSE)
	{
		$message = '';
		
		if(!$isAdmin)
		{
			if($model instanceof Users)
			{
				$message = "Магазин полиграфии 'print-shop.com.ua'. Успешная регистрация";
			}
			if($model instanceof Horders)
			{
				$message = "Магазин полиграфии 'print-shop.com.ua'. Ваш заказ № ".$model->num."";
			}
		}
		if($isAdmin)
		{
			if($model instanceof Users)
			{
				$message = "Регистрация нового пользователя.";
			}
			if($model instanceof Horders)
			{
				$message = "Заказ № ".$model->num."";
			}
		}
					
		return $message;
		
	}
	
	public static function getMessage($model, $isAdmin = FALSE)
	{
		$message = '';
		if(!$isAdmin)
		{
			if($model instanceof Users)
			{
				$message = "Уважаемый ".$model->profile->first_name." ".$model->profile->second_name." ".$model->profile->last_name." !<br>";
				$message .= "<p>Вы успешно зарегистрированы в интернет-магазине полиграфии 'print-shop.com.ua.'</p>";
				$message .= "<p>Ваш логиин: ".$model->username."</p>";
				$message .= "<p>Ваш пароль: ".$model->password."</p>";
			}
			if($model instanceof Horders)
			{
				$message = "<table>
								<thead>
									<tr>
										<th>№пп</th>
										<th>Срок</th>
										<th>Продукт</th>
										<th>Тираж</th>
										<th>Материал</th>
										<th>Покрытие</th>
										<th>Сумма</th>
									</tr>
								</thead><tbody>";
					$i = (int)TRUE;
					
					foreach($model->orders as $value)
					{
						$message.="<tr><td>".$i."</td>
										<td>".$value->product->sroki."</td>
										<td>".$value->product->name."</td>
										<td>".$value->product->tirazh."</td>
										<td>".$value->product->material."</td>
										<td>".$value->product->pokritie."</td>
										<td>".$value->product->price_client."</td></tr>";
						$i++;
					}
					$message.="</tbody></table>";
			}
		}
		if($isAdmin)
		{
			if($model instanceof Users)
			{
				$message .= "<p>На сайте зарегистрирован новый пользователь</p>";
				$message .= "<p>Логиин: ".$model->username."</p>";
				$message .= "<p>ФИО: ".$model->profile->first_name." ".$model->profile->second_name." ".$model->profile->last_name."</p>";
			}
			if($model instanceof Horders)
			{
				$message = "e-mail: ".$model->email."<br>";
				$message .= "тел.: ".$model->phone."<br>";
				$message .= "<table>
								<thead>
									<tr>
										<th>№пп</th>
										<th>Срок</th>
										<th>Продукт</th>
										<th>Тираж</th>
										<th>Материал</th>
										<th>Покрытие</th>
										<th>Сумма</th>
									</tr>
								</thead><tbody>";
				$i = (int)TRUE;
				
				foreach($model->orders as $value)
				{
					$message .="<tr><td>".$i."</td>
									<td>".$value->product->sroki."</td>
									<td>".$value->product->name."</td>
									<td>".$value->product->tirazh."</td>
									<td>".$value->product->material."</td>
									<td>".$value->product->pokritie."</td>
									<td>".$value->product->price_client."</td></tr>";
					$i++;
				}
				$message .="</tbody></table>";
			}
			
		}
					
		return $message;
		
	}
	
}
