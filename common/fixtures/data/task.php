<?php

use Faker\Factory;
$faker = Factory::create();

$count = 15;

function getTask($faker) {
    $faker = Factory::create();
    $date = $faker->dateTimeInInterval('-1 year', '+1 year', null);
    return [
        'category_id' => rand(1, 8),
        'title' => $faker->sentence(6, true),
        'description' => $faker->paragraph(3, true),
        'city_id' => rand(1, 100),
        'user_id' => 2,
        'executor_id' => '',
        'address' => $faker->address,
        'location' => "30.31735 59.968322",
        'budget' => rand(1000, 150000),
        'deadline' => $date->format('Y-m-d'),
        'status_id' => 5,
        'created_at' => $date->format('Y-m-d H:i:s')
    ];
}

$users = [];

for ($i = 0; $i < $count; $i++) {
    $users[] = getTask($faker);
}

return $users;
