<?php

class Contact
{
    /**
    * Добавить контакт
    */
    public function addContact($name, $responsible, $phone, $email)
    {
        try {
            $result = CRest::call(
                'crm.contact.add',
                [
                    'fields' =>[
                       'NAME' => $name,
                       'ASSIGNED_BY_ID' => $responsible,
                       'PHONE' => [
                            0 => [
                                'VALUE' => (string)$phone
                            ]
                       ],
                       'EMAIL' => [
                            0 => [
                                'VALUE' => $email
                            ]
                        ]
                    ]
                ]
            );
            return $result;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }
    
    /**
    * Поиск контакта по email
    */
    public function searchByEmail($email)
    {
        try {
            $result = CRest::call(
                'crm.contact.list',
                [
                    'filter' => [
                        'EMAIL' => $email
                    ],
                    'select' => [
                       'ID','ASSIGNED_BY_ID'
                    ]
                ]
            );
            return $result;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
    * Поиск контакта по телефону
    */
    public function searchByPhone($phone)
    {
        try {
            $result = CRest::call(
                'crm.contact.list',
                [
                    'filter' => [
                        'PHONE' => (string)$phone
                    ],
                    'select' => [
                       'ID','ASSIGNED_BY_ID'
                    ]
                ]
            );
            return $result;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
    * Получить контакт по id
    */
    public function getContact($id)
    {
        try {
            $result = CRest::call(
                'crm.contact.get',
                [
                    'id' => $id
                ]
            );
            return $result;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }
}