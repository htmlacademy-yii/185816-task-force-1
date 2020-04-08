<?php


namespace frontend\forms;


use frontend\models\Category;
use frontend\models\City;
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
    public $location;

    public function attributeLabels()
    {
        return [
            'title' => 'Мне нужно',
            'description' => 'Подробности задания',
            'category_id' => 'Категория',
            'city_id' => 'Город',
            'location' => 'Локация',
            'budget' => 'Бюджет',
            'deadline' => 'Срок исполнения',
            'file' => 'Изображение'
        ];
    }

    public function rules()
    {
        return [
            [['title', 'description', 'category_id', 'deadline'], 'required', 'message' => 'Поле не может быть пустым'],
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
                'extensions' => ['png', 'jpg', 'jpeg']
            ],
        ];
    }

    public function upload()
    {
        if (UploadedFile::getInstance($this, 'file')) {
            $this->file = UploadedFile::getInstance($this, 'file');
            $this->file->saveAs('uploads/' . $this->file->baseName . '.' . $this->file->extension);

            return 'upload/' . $this->file->baseName . '.' . $this->file->extension;
        } else {
            return '';
        }
    }
}
