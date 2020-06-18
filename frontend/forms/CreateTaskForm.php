<?php


namespace frontend\forms;


use common\models\Category;
use yii\base\Model;
use yii\web\UploadedFile;

class CreateTaskForm extends Model
{
    public $title;
    public $description;
    public $category_id;
    public $city_id;
    public $budget;
    public $deadline;
    public $file;
    public $address;
    protected $dir = 'upload/';

    public function attributeLabels()
    {
        return [
            'title' => 'Мне нужно',
            'description' => 'Подробности задания',
            'category_id' => 'Категория',
            'city_id' => 'Город',
            'address' => 'Локация',
            'budget' => 'Бюджет',
            'deadline' => 'Срок исполнения',
            'file' => 'Изображение'
        ];
    }

    public function rules()
    {
        return [
            [['title', 'description', 'category_id', 'deadline', 'address'], 'required', 'message' => 'Поле не может быть пустым'],
            ['budget', 'integer', 'min' => 1, 'message' => 'Поле должно быть числом, не меньше нуля'],
            [
                'category_id',
                'exist',
                'targetClass' => Category::class,
                'message' => 'Такогой категории не существует',
                'targetAttribute' => 'id'
            ],
            [
                'deadline',
                'date',
                'format' => 'php:Y-m-d',
                'message' => 'Введите дату в правильном формате YYYY-mm-dd'
            ],
            [
                'file',
                'file',
                'message' => 'Изображение должно иметь формат jpg, png, jpeg',
                'extensions' => ['png', 'jpg', 'jpeg', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pdf'],
                'maxSize' => 1024 * 1024
            ],
        ];
    }

    /**
     * @return string
     */

    public function upload()
    {
        if (!file_exists($this->dir)) {
            mkdir($this->dir, 0775);
        }

        if (UploadedFile::getInstance($this, 'file')) {
            $this->file = UploadedFile::getInstance($this, 'file');
            $this->file->saveAs($this->dir . $this->file->baseName . '.' . $this->file->extension);

            return '/' .  $this->dir . $this->file->baseName . '.' . $this->file->extension;
        } else {
            return '';
        }
    }
}
