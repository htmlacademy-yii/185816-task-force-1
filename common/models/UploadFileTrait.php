<?php


namespace common\models;


use yii\web\UploadedFile;

trait UploadFileTrait
{
    protected $dir = 'upload/';
    public $file;

    /**
     * @param $model
     * @param $attribute
     * @param bool $oldFile
     * @return string
     */
    public function upload($model, $attribute, $oldFile = false): string
    {
        if (!file_exists($this->dir)) {
            mkdir($this->dir, 0775);
        }

        if (UploadedFile::getInstance($model, $attribute)) {
            $this->file = UploadedFile::getInstance($model, $attribute);
            $this->file->saveAs($this->dir . $this->file->baseName . '.' . $this->file->extension);

            return '/' .  $this->dir . $this->file->baseName . '.' . $this->file->extension;
        } else {
            return $oldFile;
        }
    }
}
