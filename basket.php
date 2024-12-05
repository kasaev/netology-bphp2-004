<?php

declare(strict_types = 1);

const OPERATION_EXIT = 0;
const OPERATION_ADD = 1;
const OPERATION_DELETE = 2;
const OPERATION_PRINT = 3;
const OPERATION_EDIT = 4;

$operations = [
    OPERATION_EXIT => OPERATION_EXIT . '. Завершить программу.',
    OPERATION_ADD => OPERATION_ADD . '. Добавить товар в список покупок.',
    OPERATION_DELETE => OPERATION_DELETE . '. Удалить товар из списка покупок.',
    OPERATION_PRINT => OPERATION_PRINT . '. Отобразить список покупок.',
    OPERATION_EDIT => OPERATION_EDIT . '. Редактировать список покупок.',
];

$items = [];


do {
    system('clear');
//    system('cls'); // windows

    do {

        displayList($items);
        // if (count($items)) {
        //     // echo 'Ваш список покупок: ' . PHP_EOL;
        //     // echo implode("\n", $items) . "\n";
        // } else {
        //     echo 'Ваш список покупок пуст.' . PHP_EOL;
        // }


        echo 'Выберите операцию для выполнения: ' . PHP_EOL;
        // Проверить, есть ли товары в списке? Если нет, то не отображать пункт про удаление товаров
        displayOperations($operations);
        // echo implode(PHP_EOL, $operations) . PHP_EOL . '> ';
        $operationNumber = trim(fgets(STDIN));

        if (!array_key_exists($operationNumber, $operations)) {
            system('clear');
            echo '!!! Неизвестный номер операции, повторите попытку.' . PHP_EOL;
        }

    } while (!array_key_exists($operationNumber, $operations));

    echo 'Выбрана операция: '  . $operations[$operationNumber] . PHP_EOL;

    switch ($operationNumber) {
        case OPERATION_ADD:
            echo "Введение название товара для добавления в список: \n> ";
            $itemName = trim(fgets(STDIN));
            // $items[] = $itemName;
            $items = addItem($items, $itemName);
            break;

        case OPERATION_DELETE:
            // Проверить, есть ли товары в списке? Если нет, то сказать об этом и попросить ввести другую операцию
            //   echo 'Текущий список покупок:' . PHP_EOL;
            // echo 'Список покупок: ' . PHP_EOL;
            // echo implode("\n", $items) . "\n";
            displayList($items);

            echo 'Введение название товара для удаления из списка:' . PHP_EOL . '> ';
            $itemName = trim(fgets(STDIN));

            $items = deleteItem($items, $itemName);

            // if (in_array($itemName, $items, true) !== false) {
            //     while (($key = array_search($itemName, $items, true)) !== false) {
            //         unset($items[$key]);
            //     }
            // }
            break;

        case OPERATION_EDIT: 
            displayList($items);
            echo 'Введите название товара, который вы хотите изменить: ' . PHP_EOL . '> ';
            $itemName = trim(fgets(STDIN));

            echo 'Введите новое название товара: ' . PHP_EOL . '> ';
            $newItemName = trim(fgets(STDIN));
            $items = editItem($items, $itemName, $newItemName);

            break;

        case OPERATION_PRINT:
            // echo 'Ваш список покупок: ' . PHP_EOL;
            // echo implode(PHP_EOL, $items) . PHP_EOL;
            // echo 'Всего ' . count($items) . ' позиций. '. PHP_EOL;
            displayList($items, true);

            echo 'Нажмите enter для продолжения';
            fgets(STDIN);
            break;
    }

    echo "\n ----- \n";

} while ($operationNumber > 0);

echo 'Программа завершена' . PHP_EOL;






function displayList(array $items, bool $showTotal = false) : void {
    if (count($items)) {

        echo 'Ваш список покупок: ' . PHP_EOL;
        echo implode(PHP_EOL, $items) . PHP_EOL;
    } else {
        echo 'Ваш список покупок пуст.' . PHP_EOL;
    }

    if ($showTotal) {
        echo 'Всего ' . count($items) . ' позиций. '. PHP_EOL; 
    }
}


function addItem(array $items, string $itemName) : array {
    $items[] = $itemName;
    return $items;
}


function deleteItem(array $items, string $itemName) : array {
    if (in_array($itemName, $items, true) !== false) {
        while (($key = array_search($itemName, $items, true)) !== false) {
            unset($items[$key]);
        }
    } else {
        echo 'Удаление невозможно! Товара "' . $itemName . '" нет в списке покупок. ' . PHP_EOL; 
    }
    return $items;
}

function editItem(array $items, string $itemName, string $newItemName = '') : array {
    if (in_array($itemName, $items, true) !== false) {
        while (($key = array_search($itemName, $items, true)) !== false) {
            $items[$key] = $newItemName;
        }
    } else {
        echo 'Изменение товара невозможно! Товара "' . $itemName . '" нет в списке покупок. ' . PHP_EOL; 
    }

    return $items;
}


function displayOperations($operations) : void {
    echo implode(PHP_EOL, $operations) . PHP_EOL . '> ';
}