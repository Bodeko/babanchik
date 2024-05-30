<?php

$stmt = $mysqli->prepare("SELECT COUNT(*) FROM Project");
$stmt->execute();
$projects = $stmt->get_result()->fetch_row()[0];

$stmt = $mysqli->prepare("SELECT COUNT(*) FROM Participant WHERE role = 'contractor'");
$stmt->execute();
$freelancers = $stmt->get_result()->fetch_row()[0];

$stmt = $mysqli->prepare("SELECT COUNT(*) FROM Participant WHERE role = 'client'");
$stmt->execute();
$clients = $stmt->get_result()->fetch_row()[0];


?>

<div id="index__promotional__main-block">
    <h2 class="centered-text">Фрилансхант у цифрах</h2>
    <div id="index__promotional__card-block">
        <div class="index__promotional__card double-row centered-text">
            <h1>Замовників:</h1>
            <h1><?=$clients?></h1>
        </div>
        <div class="index__promotional__card double-row centered-text">
            <h1>Фрилансерів:</h1>
            <h1><?=$freelancers?></h1>
        </div>
        <div class="index__promotional__card double-row centered-text">
            <h1>Проєктів:</h1>
            <h1><?=$projects?></h1>
        </div>

        </div>
    </div>
        <h2 class="centered-text"><strong>Чому фрилансери обирають Free</strong>lance</h2>

    <div id="index__promotional__why-us-block">
        <div id="index__promotional__why-us-block__image-block">
            <img src="../images/шшш1.PNG"/>
        </div>
        <div id="index__promotional__why-us-block__info-block">
                <h2 class="centered-text block-label-bordered-black">Проєкти для новачков та професіоналів</h2>
                <h2 class="centered-text block-label-bordered-black">Чесний рейтинг</h2>
        </div>
    </div>
</div>
