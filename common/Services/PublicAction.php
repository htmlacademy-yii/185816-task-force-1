<?php


namespace App\Services;


class PublicAction extends AvailableActions
{
    protected $roles = [self::ADMIN_ROLE, self::CUSTOMER_ROLE];
    protected $statuses = [self::WORK, self::CANCEL];

    public function getAction()
    {
        return $this->getClass(__CLASS__);
    }

    public function getName()
    {
        return __CLASS__;
    }

    public function checkPermission($user)
    {
        return parent::checkPermissionUser($user, $this->roles);
    }

    public function getActions($user)
    {
        $response = parent::getAvailableActions($user, $this->roles, $this->statuses);

        return 'Текущий класс: ' . $this->getAction() . "<br><br>" . $response;
    }
}
