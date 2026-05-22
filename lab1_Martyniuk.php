<?php

// Завадння 1: добуток всіх чисел
echo "Завдання 1: добуток всіх чисел\n";
echo "Введіть числа через пробіл: ";
$input = readline();
$arr = explode(" ", trim($input));

$product = 1;
foreach ($arr as $item) {
    $product *= $item;
}
echo "Добуток чисел масиву: " . $product . "\n\n";

// Завадння 2: досконалі числа
echo "Завадння 2: досконалі числа\n";
$arr2 = [];
for ($i = 0; $i < 15; $i++) {
    $arr2[] = rand(1, 1000);
}
echo "Згенерований масив: " . implode(", ", $arr2) . "\n";
echo "Досконалі числа: ";
foreach ($arr2 as $num) {
    if ($num <= 1) continue;
    $sum = 0;
    for ($j = 1; $j < $num; $j++) {
        if ($num % $j == 0) {
            $sum += $j;
        }
    }
    if ($sum == $num) {
        echo $num . " ";
    }
}
echo "\n\n";

// Завадння 3: кількість нулів у масиві
echo "Завадння 3: кількість нулів у масиві\n";
echo "Введіть масив чисел через пробіл: ";
$input3 = readline();
$arr3 = explode(" ", trim($input3));

$zeros = 0;
foreach ($arr3 as $item) {
    if ($item == 0) {
        $zeros += 1;
    }
}

echo "Кількість нулів у масиві: " . $zeros . "\n\n";


// Завадння 4: сума квадратів непарних чисел
echo "Завадння 4: сума квадратів непарних чисел\n";
$arr4 = [];
for ($i = 0; $i < 20; $i++) {
    $arr4[] = rand(1, 50);
}
echo "Згенерований масив: " . implode(", ", $arr4) . "\n";

$sum_sqrt = 0;
foreach ($arr4 as $num) {
    if ($num % 2 != 0) {
        $sum_sqrt += pow($num, 2);
    }
}
echo "Сума квадратів непарних чисел: " . $sum_sqrt . "\n\n";


// Завадння 5: обмін першого і останнього елементів масиву
echo "Завадння 5: обмін першого і останнього елементів масиву\n";
$arr5 = [];
for ($i = 0; $i < 8; $i++) {
    $arr5[] = rand(1, 100);
}

echo "Згенерований масив (до обміну): " . implode(", ", $arr5) . "\n";

$first = $arr5[0];
$arr5[0] = $arr5[7];
$arr5[7] = $first;
echo "Масив після обміну: " . implode(", ", $arr5) . "\n\n";


// Завадння 6: середнє арифметичне додатніх чисел у масиві
echo "Завадння 6: середнє арифметичне додатніх чисел у масиві\n";
$arr6 = [];
for ($i = 0; $i < 10; $i++) {
    $arr6[] = rand(-50, 50);
}
echo "Згенерований масив: " . implode(", ", $arr6) . "\n";

$sum6 = 0;
$count6 = 0;
foreach ($arr6 as $num) {
    if ($num > 0) {
        $sum6 += $num;
        $count6++;
    }
}
if ($count6 > 0) {
    $avg = $sum6 / $count6;
    echo "Середнє арифметичне додатних чисел масиву: " . $avg . "\n\n";
} else {
    echo "Додатніх чисел немає\n\n";
}


// Завадння 7: перетворення піб на email
echo "Завадння 7: перетворення піб на email\n";
echo "Введіть ПІБ (наприклад: Гарбузюк Олег): ";
$pib = readline();

$pib_lower = mb_strtolower(trim($pib), 'UTF-8');
$replace = [
    'а' => 'a',  'б' => 'b',  'в' => 'v',  'г' => 'h',  'ґ' => 'g',
    'д' => 'd',  'е' => 'e',  'є' => 'ye', 'ж' => 'zh', 'з' => 'z',
    'и' => 'y',  'і' => 'i',  'ї' => 'yi', 'й' => 'y',  'к' => 'k',
    'л' => 'l',  'м' => 'm',  'н' => 'n',  'о' => 'o',  'п' => 'p',
    'р' => 'r',  'с' => 's',  'т' => 't',  'у' => 'u',  'ф' => 'f',
    'х' => 'kh', 'ц' => 'ts', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'shch',
    'ь' => '',   'ю' => 'yu', 'я' => 'ya', ' ' => '.'
];

$email_name = "";
for ($i = 0; $i < mb_strlen($pib_lower, 'UTF-8'); $i++) {
    $char = mb_substr($pib_lower, $i, 1, 'UTF-8');
    if (isset($replace[$char])) {
        $email_name .= $replace[$char];
    } else {
        $email_name .= $char;
    }
}
echo "Результат: " . $email_name . "@example.com\n\n";


// Завадння 8: рік кратний 400
echo "Завадння 8: рік кратний 400\n";
echo "Введіть рік: ";
$year = trim(readline());
if (!is_numeric($year)) {
    echo "Помилка! Ви ввели не число.\n\n";
} else {
    if ($year % 400 == 0) {
        echo "Рік, який Ви ввели кратний 400\n\n";
    } else {
        echo "Рік не кратний 400\n\n";
    }
}


// Завадння 9: добуток елементів з парними індексами та вивід непарних
echo "Завадння 9: добуток елементів з парними індексами та вивід непарних\n";
$arr9 = [];
for ($i = 0; $i < 10; $i++) {
    $arr9[] = rand(0, 100);
}
echo "Згенерований масив: " . implode(", ", $arr9) . "\n";
$product9 = 1;
echo "Елементи > 0 з непарними індексами:\n";

for ($index = 0; $index < count($arr9); $index++) {
    $value = $arr9[$index];

    if ($value > 0) {
        if ($index % 2 == 0) {
            $product9 = $product9 * $value;
        } else {
            echo "Індекс $index => Значення $value\n";
        }
    }
}
echo "Добуток елементів > 0 з парними індексами: " . $product9 . "\n\n";


// Завадння 10: перевірка на високосний рік
echo "Завадння 10: перевірка на високосний рік\n";
echo "Введіть рік (1-9999): ";
$year10 = trim(readline());
if (!is_numeric($year10)) {
    echo "Помилка! Ви ввели не число.\n\n";
} else {
if (($year10 % 4 == 0 && $year10 % 100 != 0) || ($year10 % 400 == 0)) {
    echo "Рік високосний\n";
} else {
    echo "Рік не високосний\n";
}}

