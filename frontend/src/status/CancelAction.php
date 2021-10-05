<?php


namespace frontend\src\status;

use frontend\src\exceptions\StatusException;

class CancelAction extends AvailableActions
{
    protected $roles = [self::ROLE_ADMIN, self::ROLE_CUSTOMER];
    protected $nextStatus = self::STATUS_CANCEL;
    protected $accessStatuses = [self::STATUS_PUBLIC];

   public function checkPermission(): void
   {
       if(!$this->task->isUserOwner($this->currentUser)) {
           throw new StatusException('Доступ запрещен, обратитесь к администратору');
       }
   }
}
