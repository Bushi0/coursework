<?php
$hashedPassword = '$2y$10$Syt1DPiNwZTZmECLYlu4de5fHeJfRODQDy1BiIDFxP978OnH1KYjq';
$userInputPassword = '1';

if (password_verify($userInputPassword, $hashedPassword)) {
    echo 'Пароли совпадают!';
} else {
    echo 'Пароли не совпадают.';
}
?>