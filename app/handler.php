<?php
require_once('bootstrap.php');

$helper = new Helper();

// Валидация данных с формы
if (empty($_POST['email']) || empty($_POST['phone'])) {
    echo 'Переданы не все параметры';
    http_response_code(400);
} else {
    $data = $helper->validateForm($_POST);
}

// Если не введено имя называем 'Безымянный контакт'
$name = !empty($data['name']) ? $data['name'] : 'Безымянный контакт';


$contact = new Contact();

// Ищем контакт по email и телефону
try {
    $resultByEmail = $contact->searchByEmail($data['email'])['result'];
    $resultByPhone = $contact->searchByPhone($data['phone'])['result'];
} catch (Exception $e) {
    echo 'Ошибка при поиске дубликатов контакта';
    var_dump($e);
    http_response_code(501);
    exit;
}

$user = new User();
$deal = new Deal();

switch (true) {
    // Берём ответственного из найденного контакта
    case !empty($resultByEmail):
        $responsible = $resultByEmail[0]['ASSIGNED_BY_ID'];
        break;
    case !empty($resultByPhone):
        $responsible = $resultByPhone[0]['ASSIGNED_BY_ID'];
        break;
    default:
        // Иначе получаем ответственного с помощью распределения
        $users = $user->getUsers()['result'];
        $deals = $deal->getDeals(
            ['>DATE_CREATE' => date(DATE_ATOM, strtotime("-1 day")),'>ASSIGNED_BY_ID' => 1, '>CONTACT_ID' => 0],
            ['ID','ASSIGNED_BY_ID', 'CONTACT_ID']
        )['result'];
        $responsible = $helper->getNextResponsible($deals, $users);
}


// Добавляем сделку
try {
    $dealId = $deal->addDeal(TITLE, STAGE_ID, $responsible)['result'];
} catch (Exception $e) {
    echo 'Ошибка при добавлении сделки';
    var_dump($e);
    http_response_code(502);
    exit;
}

// Если не нашли контакт создаём новый и привязываем его к сделке
if (empty($resultByEmail) && empty($resultByPhone)) {
    try {
        $contactId = $contact->addContact($name, $responsible, $data['phone'], $data['email'])['result'];
        $deal->dealContactAdd($dealId, $contactId);
    } catch (Exception $e) {
        echo 'Ошибка при добавлении контакта';
        var_dump($e);
        http_response_code(503);
        exit;
    }
} else {
    // Если контакт нашли привязываем его к сделке
    try {
        if (!empty($resultByEmail)) {
            $deal->dealContactAdd($dealId, $resultByEmail[0]['ID']);
        } elseif (!empty($resultByPhone)) {
            $deal->dealContactAdd($dealId, $resultByPhone[0]['ID']);
        }
    } catch (Exception $e) {
        echo 'Ошибка при привязке контакта к сделке';
        var_dump($e);
        http_response_code(504);
        exit;
    }
}

// Добавляем задачу
$task = new Task();
$deadline = date(DATE_ATOM, strtotime("+1 day"));

try {
    $task->addTask(TASK_NAME.' '.$name, $responsible, $deadline);
} catch (Exception $e) {
    echo 'Ошибка при добавлении задачи';
    var_dump($e);
    http_response_code(505);
    exit;
}

//Отправляем письмо на почту админа
$helper->sendMail($user->getAdminEmail(), MAIL_ADDRESS, $data);
