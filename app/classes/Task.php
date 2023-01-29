<?php

class Task
{
    /**
    * Добавить задачу
    */
    public function addTask($name, $responsible, $deadline)
    {
        try {
            $result = CRest::call(
                'tasks.task.add',
                [
                    'fields' =>[
                       'TITLE' => $name,
                       'RESPONSIBLE_ID' => $responsible,
                       'DEADLINE' => $deadline
                    ]
                ]
            );
            return $result;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }
}
