<?php
/**
 * @author Andriy Tolstokorov
 */

class ComplaintForm extends CFormModel
{
    const FORM_ID = 'complaint-form';
    public $on_id;
    public $content;
    public $verifyCode;

    public function rules()
    {
        return array(
            array(
                'on_id, content',
                'required',
                'message' => 'Поле обов\'язкове!'
            ),

            array(
                'verifyCode',
                'captcha',
                'allowEmpty'=>!CCaptcha::checkRequirements(),
                'captchaAction' => Yii::app()->createUrl( 'site/captcha' ),
                'message' => 'Код введено невірно!'
            ),
        );
    }

    public function attributeLabels()
    {
        return array(
            'verifyCode' => 'Код',
            'content' => 'Причина'
        );
    }

    public function setOnId( $onId )
    {
        $this->on_id = $onId;
    }

    public function getOnId()
    {
        return $this->on_id;
    }



    public function save()
    {
        UserComplaints::createComplaint( Yii::app()->user->id, $this->on_id, $this->content );
    }
}