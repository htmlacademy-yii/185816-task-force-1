<?php


namespace frontend\forms;


use common\models\UploadFileTrait;
use Yii;
use yii\base\Model;

class PhotoJobForm extends Model
{
    use UploadFileTrait;

    const MAX_FILES = 6;

    public $user_id;
    public $img;

    public function rules(): array
    {
        return [
            [['user_id', 'photos'], 'required'],
            ['user_id', 'integer'],
            [['photos'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'maxFiles' => self::MAX_FILES],
        ];
    }

    public function init()
    {
        $this->user_id = Yii::$app->user->id;
        parent::init();
    }

    /**
     * Return this class in static methods
     *
     * @return PhotoJobForm
     */

    public static function loadFile(): PhotoJobForm
    {
        $form = new self();
        $form->file = $form->upload($form, 'photos');
        return $form;
    }
}
