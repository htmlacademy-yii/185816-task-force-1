<?php

namespace frontend\src\status;

use common\models\Task;
use common\models\User;
use frontend\src\exceptions\StatusException;

abstract class AvailableActions
{
    const STATUS_WORK = 1;
    const STATUS_COMPLETE = 2;
    const STATUS_FAILED = 3;
    const STATUS_CANCEL = 4;
    const STATUS_PUBLIC = 5;
    const ROLE_ADMIN = 1;
    const ROLE_CUSTOMER = 2;
    const ROLE_EXECUTOR = 3;

    public $task;
    public $currentUser;
    protected $nextStatus = 0;
    protected $accessStatuses = [];

    /**
     * AvailableActions constructor.
     * @param Task $task
     * @param User $targetUser
     */
    public function __construct(Task $task, User $targetUser)
    {
        $this->task = $task;
        $this->currentUser = $targetUser;
    }

    abstract function checkPermission(): void;

    /**
     * @return int
     */

    public function getCurrentStatus(): int
    {
        return $this->task->status_id;
    }

    /***
     * @return int
     */

    public function getNextStatus(): int
    {
        return $this->nextStatus;
    }

    /**
     * @return int
     */

    public function getUserRole(): int
    {
        return $this->task->user->role_id;
    }

    /**
     * @return int
     */

    public function getExecutorRole(): int
    {
        return $this->task->executor->role_id;
    }

    /***
     * @param int $userRole
     * @param array $roles
     * @return bool
     */

    protected static function checkRole(int $userRole, array $roles): bool
    {
        return in_array($userRole, $roles);
    }

    /***
     * Set next status for Task
     */

    public function setNextStatus()
    {
        if (!self::checkRole($this->currentUser->role_id, $this->roles)) {
            throw new StatusException('У вас недостаточно прав');
        }

        if ($this->task->status_id === $this->nextStatus) {
            throw new StatusException('Статус задания уже обновлен');
        }

        if (!self::checkAccessStatus($this->getCurrentStatus(), $this->accessStatuses)) {
            throw new StatusException('Ошибка смены статуса');
        } else {
            $this->task->status_id = $this->nextStatus;
        }
    }

    public static function checkAccessStatus(int $currentStatus, array $accessStatuses)
    {
        return in_array($currentStatus, $accessStatuses);
    }

    public function apply(): void
    {
        $this->checkPermission();
        $this->setNextStatus();
        $this->task->save();
    }
}
