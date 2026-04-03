<?php
declare(strict_types=1);


$transactions = [
    [
        "id" => 1,
        "date" => "2019-01-01",
        "amount" => 100.00,
        "description" => "Payment for groceries",
        "merchant" => "SuperMart",
    ],
    [
        "id" => 2,
        "date" => "2020-02-15",
        "amount" => 75.50,
        "description" => "Dinner with friends",
        "merchant" => "Local Restaurant",
    ],
];


function calculateTotalAmount(array $transactions): float {
    $sum = 0;
    foreach ($transactions as $t) {
        $sum += $t['amount'];
    }
    return $sum;
}

function findTransactionByDescription(string $descriptionPart): array {
    global $transactions;
    return array_filter($transactions, function($t) use ($descriptionPart) {
        return stripos($t['description'], $descriptionPart) !== false;
    });
}


function findTransactionById(int $id): ?array {
    global $transactions;
    foreach ($transactions as $t) {
        if ($t['id'] === $id) {
            return $t;
        }
    }
    return null;
}


function findTransactionByIdFilter(int $id): array {
    global $transactions;
    return array_filter($transactions, fn($t) => $t['id'] === $id);
}


function daysSinceTransaction(string $date): int {
    $transactionDate = new DateTime($date);
    $today = new DateTime();
    return $today->diff($transactionDate)->days;
}


function addTransaction(int $id, string $date, float $amount, string $description, string $merchant): void {
    global $transactions;

    $transactions[] = [
        "id" => $id,
        "date" => $date,
        "amount" => $amount,
        "description" => $description,
        "merchant" => $merchant,
    ];
}


addTransaction(3, "2023-05-10", 200.00, "Online shopping", "Amazon");


usort($transactions, function($a, $b) {
    return strtotime($a['date']) <=> strtotime($b['date']);
});


usort($transactions, function($a, $b) {
    return $b['amount'] <=> $a['amount'];
});


?>

<!DOCTYPE html>
<html>
<head>
    <title>Bank Transactions</title>
    <style>
        body { font-family: Arial; }
        table { border-collapse: collapse; width: 100%; }
        th, td { padding: 8px; text-align: center; border: 1px solid black; }
        img { width: 150px; margin: 5px; }
    </style>
</head>
<body>

<h2>Список транзакций</h2>

<table>
<thead>
<tr>
    <th>ID</th>
    <th>Date</th>
    <th>Amount</th>
    <th>Description</th>
    <th>Merchant</th>
    <th>Days Ago</th>
</tr>
</thead>

<tbody>
<?php foreach ($transactions as $t): ?>
<tr>
    <td><?= $t['id'] ?></td>
    <td><?= $t['date'] ?></td>
    <td><?= $t['amount'] ?></td>
    <td><?= $t['description'] ?></td>
    <td><?= $t['merchant'] ?></td>
    <td><?= daysSinceTransaction($t['date']) ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<h3>Общая сумма: <?= calculateTotalAmount($transactions) ?></h3>

<hr>

<h2>Галерея изображений</h2>
<?php

$files = [];


for ($i = 1; $i <= 25; $i++) {
    $files[] = "https://picsum.photos/200?random=" . $i;
}


if ($files === false) {
   return;
}

for ($i = 0; $i < count($files); $i++) {

   if (!empty($files[$i])) {

       $path = $files[$i];
?>
       <img src="<?= $path ?>" style="width:200px; margin:5px;">
<?php
   }
}
?>

</body>
</html>
