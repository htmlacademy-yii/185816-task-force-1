<?php


namespace frontend\src\status;


use common\models\Task;
use common\models\User;
use frontend\src\exceptions\StatusException;

class CompleteAction extends AvailableActions
{
    protected const COMPLETE_SUCCESS = 1;
    protected $roles = [self::ROLE_ADMIN, self::ROLE_CUSTOMER];
    protected $nextStatus = self::STATUS_COMPLETE;
    protected $accessStatuses = [self::STATUS_WORK];

    public $completed;

    public function __construct(Task $task, User $targetUser, $completed)
    {
        $this->completed = $completed;
        parent::__construct($task, $targetUser);
    }

    public function checkPermission(): void
    {
        if(!$this->task->isUserOwner($this->currentUser)) {
            throw new StatusException('Доступ запрещен, обратитесь к администратору');
        }
    }

    /**
     * @return bool
     */

    public function isComplete()
    {
        return $this->completed === self::COMPLETE_SUCCESS;
    }
}
