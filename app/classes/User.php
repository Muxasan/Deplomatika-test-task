<?php

class User
{
    /**
    * Получить пользователей
    */
    public function getUsers()
    {
        try {
            $result = CRest::call(
                'user.get',
                [
                    'FILTER' =>[
                       'USER_TYPE' => 'employee',
                       'ACTIVE' => true
                    ]
                ]
            );
            return $result;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
    * Получить почту админа
    */
    public function getAdminEmail()
    {
        try {
            $result = CRest::call(
                'user.get',
                [
                    'id' => 1
                ]
            );
            return $result['result'][0]['EMAIL'];
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }
}
