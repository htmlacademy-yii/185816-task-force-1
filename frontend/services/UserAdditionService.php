<?php


namespace frontend\services;

use common\models\CategoryExecutor;
use common\models\User;
use common\models\UserSettings;
use frontend\forms\UserSettingsForm;
use frontend\helpers\SessionNotices;
use Yii;
use yii\db\Exception;

class UserAdditionService
{
    /**
     * @var User $user
     */
    protected $user;
    /**
     * @var CategoryExecutor
     */
    protected $categoryExecutor;
    /**
     * @var UserSettings
     */
    protected $userSetting;

    /**
     * @var UserSettingsForm $form
     */
    protected $form;

    /**
     * UserAdditionService constructor.
     * @param User $user
     * @param UserSettingsForm $form
     * @throws \yii\base\Exception
     */

    public function __construct(User $user, UserSettingsForm $form)
    {
        $this->user = $user;
        $this->form = $form;
        $this->categoryExecutor = CategoryExecutor::class;
        $this->userSetting = UserSettings::class;

        $this->user->attributes = $this->form->attributes;

        $this->update();
    }

    /**
     * @param $settings
     * @return array|string
     */

    public function generateArray($settings)
    {
        $result = [];

        if (!empty($settings)) {

            foreach ($settings as $setting => $id) {
                $result[] = [$this->user->id, $id];
            }
        }

        return $result;
    }

    /**
     * Create new relationship
     *
     * @param CategoryExecutor|UserSettings $class
     * @param array $attributes
     * @param array $values
     * @throws Exception
     */

    public function updateSpecials($class, array $attributes, array $values): void
    {
        $class::deleteAll(['user_id' => $this->user->id]);

        if(count($values) > 0) {
            $query = Yii::$app->db->createCommand()
                ->batchInsert(
                    $class::tableName(),
                    $attributes,
                    $values
                );

            if (!$query->query()) {
                throw new Exception('Данные не сохранились');
            }
        }
    }

    /**
     * Check status before save
     */

    public function checkStatus()
    {
        if (!empty($this->form->specials) &&  $this->form->specials !== '') {
            $this->user->role_id = $this->user::EXECUTOR;

        } else {
            $this->user->role_id = $this->user::CUSTOMER;
        }
    }

    /**
     * @return bool
     */

    public function checkPassword(): bool
    {
        return $this->form->password_new === $this->form->password_verify;
    }

    /**
     * Update new user
     * @return bool|string
     * @throws \yii\base\Exception
     */

    public function update()
    {
        if ($this->checkPassword()) {
            $this->user->password = Yii::$app->security->generatePasswordHash($this->form->password_verify);
        } else {
            Yii::$app->session->setFlash('error', 'Пароли не совпадают, попробуйте снова');
        }

        try {
            $this->updateSpecials($this->categoryExecutor, ['user_id', 'category_id'], $this->generateArray($this->user->specials));
            $this->updateSpecials($this->userSetting, ['user_id', 'notice_category_id'], $this->generateArray($this->user->settings));
            $this->checkStatus();
            return $this->user->save();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Return new class UserSettings
     *
     * @param User $user
     * @param UserSettingsForm $formModel
     * @return UserAdditionService
     */
    public static function changeUserSettings(User $user, UserSettingsForm $formModel): UserAdditionService
    {
        return new self($user, $formModel);
    }
}
