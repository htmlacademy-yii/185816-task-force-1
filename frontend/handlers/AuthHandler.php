<?php


namespace frontend\handlers;

use common\models\Auth;
use common\models\User;
use Yii;
use yii\authclient\ClientInterface;
use yii\console\Response;
use yii\helpers\ArrayHelper;

/**
 * AuthHandler handles successful authentication via Yii auth component
 */
class AuthHandler
{
    protected $id;
    protected $fullName;
    protected $avatar;

    /**
     * @var ClientInterface
     */
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
        $this->id = ArrayHelper::getValue($this->client->getUserAttributes(), 'id');
        $this->fullName = ArrayHelper::getValue($this->client->getUserAttributes(), 'first_name') . ' ' . ArrayHelper::getValue($this->client->getUserAttributes(), 'last_name');
        $this->avatar = ArrayHelper::getValue($this->client->getUserAttributes(), 'photo');
    }

    public function handle()
    {
        if (!$this->checkExistsUser($this->id)) {
            try {
                User::createNewAuthVk($this->id, $this->fullName, $this->avatar);
                Auth::create(['user_id' => $this->id, 'source' => $this->client->getId(), 'source_id' => $this->id]);
                $user = User::findOne($this->id);
                $this->enterUser($user);
            } catch (\Exception $e) {
                echo $e->getMessage();
            }
        } else {
            $user = User::findOne($this->id);
            $this->enterUser($user);
        };

        return Yii::$app->response->redirect(['singin/index']);
    }

    /**
     * @param $id
     * @return bool
     */
    public function checkExistsUser($id)
    {
        return User::find()->where(['id' => $this->id])->exists();
    }

    /**
     * @param User $user
     * @return Response|\yii\web\Response
     */

    public function enterUser(User $user)
    {
        Yii::$app->user->login($user);
        Yii::$app->session->setFlash('success', 'Добро пожаловать', $user->full_name);
        return Yii::$app->response->redirect(['tasks/index']);
    }
}
