<?php
try {
    $connect = new PDO("mysql:host=localhost;dbname=farhaevents", "root", "");
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

$eventId = isset($_POST['eventId']) ? $_POST['eventId'] : '';

$query = "SELECT evenement.eventTitle, evenement.eventDescription, evenement.TariffNormal,
          evenement.TariffReduit, edition.image, edition.dateEvent, edition.timeEvent
          FROM evenement
          JOIN edition ON evenement.eventId = edition.eventId
          WHERE evenement.eventId = :eventId";

$stmt = $connect->prepare($query);
$stmt->bindValue(':eventId', $eventId);
$stmt->execute();
$event = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$event) {
    echo "Event not found!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Event Details</title>
    <link rel="stylesheet" href="details.css">
</head>
<body>
    <div class="details">
        <img src="<?= $event['image'] ?>" alt="Event Image">
        <h1><?= $event['eventTitle'] ?></h1>
        <p><?= $event['eventDescription'] ?></p>
        <p>Date: <?= $event['dateEvent'] ?></p>
        <p>Time: <?= $event['timeEvent'] ?></p>
        <p>Standard Ticket: <?= $event['TariffNormal'] ?> DH</p>
        <p>Discounted Ticket: <?= $event['TariffReduit'] ?> DH</p>

        <form method="POST" action="purchase.php">
            <input type="hidden" name="eventId" value="<?= $eventId ?>">
            Number of Standard Tickets: <input type="number" name="qteNormal" min="0" required>
            Number of Discounted Tickets: <input type="number" name="qteReduit" min="0" required>
            <button type="submit">Purchase</button>
        </form>
    </div>
</body>
</html>