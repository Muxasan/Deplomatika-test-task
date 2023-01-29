<?php

class Helper
{
    /**
    * Валидация данных с формы
    */
    public function validateForm($data)
    {
        if (isset($data)) {
            foreach ($data as $key => $value) {
                $value = trim($value);
                $value = stripslashes($value);
                $value = htmlspecialchars($value);
                $data[$key] = $value;
            }
            return $data;
        } else {
            return [];
        }
    }
    
    /**
    * Вычислить следующего ответственного
    */
    public function getNextResponsible($deals, $users)
    {
        $deals = $this->uniqArrayByField($deals, 'CONTACT_ID');
        if (empty($deals) && !empty($users)) {
            foreach ($users as $user) {
                if ($user['ID'] !== '1') {
                    return $user['ID'];
                }
            }
        } elseif (!empty($users) && !empty($deals)) {
            $min = count($deals);
            foreach ($users as $user) {
                if ($user['ID'] === '1') {
                    continue;
                }
                $tmp = count(array_filter($deals, function ($v) use ($user) {
                    return $v['ASSIGNED_BY_ID'] === $user['ID'];
                }));
                if ($tmp <= $min) {
                    $min = $tmp;
                    $responsible = $user['ID'];
                }
            }
        }
        if (!empty($responsible)) {
            return $responsible;
        } else {
            return 1;
        }
    }

    /**
    * Убрать все повторяющиеся элементы по одному из ключей
    */
    private function uniqArrayByField($array, $key)
    {
        foreach ($array as $val) {
            if (!isset($tmp[$val[$key]])) {
                $tmp[$val[$key]] = $val;
            }
        }
        return $tmp;
    }

    /**
    * Отправить почту в формате json
    */
    public function sendMail($to, $from, $data)
    {
        $subject = TITLE;
        $message = json_encode($data, JSON_UNESCAPED_UNICODE);
        $headers = 'From: '.$from.'\r\n Reply-To: '.$from
            .'\r\n X-Mailer: PHP/' . phpversion();

        return mail($to, $subject, $message, $headers);
    }
}
