<?php

class Deal
{
    /**
    * Добавить сделку
    */
    public function addDeal($title, $stageId, $responsible)
    {
        try {
            $result = CRest::call(
                'crm.deal.add',
                [
                    'fields' =>[
                       'TITLE' => $title,
                       'STAGE_ID' => $stageId,
                       'ASSIGNED_BY_ID' => $responsible
                    ]
                ]
            );
            return $result;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
    * Соединить сделку с контактом
    */
    public function dealContactAdd($dealId, $contactId)
    {
        try {
            $result = CRest::call(
                'crm.deal.contact.add',
                [
                    'id' => $dealId,
                    'fields' =>[
                       'CONTACT_ID' => $contactId
                    ]
                ]
            );
            return $result;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
    * Получить сделку по id
    */
    public function getDeal($id)
    {
        try {
            $result = CRest::call(
                'crm.deal.get',
                [
                    'id' => $id
                ]
            );
            return $result;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
    * Получить список сделок по фильтру с нужными полями (работает до (50?) сделок,
    * для большего количества пока не стал делать, там нужно в несколько пачек судя по всему получать)
    */
    public function getDeals($filter, $select)
    {
        try {
            $result = CRest::call(
                'crm.deal.list',
                [
                    'filter' => $filter,
                    'select' => $select
                ]
            );
            return $result;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }
}