<?php
/**
 * @author Andriy Tolstokorov
 */

class MessageForm extends CFormModel
{
    const FORM_ID = 'message-form';
    public $receiver_id;
    public $text;

    public function rules()
    {
        return array(
            array(
                'receiver_id,text',
                'required',
                'message' => 'Поле обов\'язкове!'
            ),

        );
    }

    public function attributeLabels()
    {
        return array(
            'text' => 'Текст',
            'receiver_id' => 'Одержувач',
        );
    }

    public function save()
    {
        $message = new Messages();
        $message->sender_id = Yii::app()->user->id;
        $message->receiver_id = $this->receiver_id;
        $message->text = $this->text;
        $message->is_new = TRUE;
        $message->save();
    }

    public function setReceiverId( $id )
    {
        $this->receiver_id = $id;
    }
}