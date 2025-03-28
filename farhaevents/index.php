<?php 
try {
    $connect = new PDO("mysql:host=localhost;dbname=farhaevents", "root", "");
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

$searchTitle = isset($_POST['searchTitle']) ? $_POST['searchTitle'] : '';

$query = "SELECT edition.image, edition.dateEvent, edition.timeEvent, edition.NumSalle,
          evenement.eventTitle, evenement.eventType, evenement.eventId
          FROM edition
          JOIN evenement ON edition.eventId = evenement.eventId";


if ($searchTitle != '') {
    $query .= " WHERE evenement.eventTitle LIKE :searchTitle";
}

$stmt = $connect->prepare($query);


if ($searchTitle != '') {
    $stmt->bindValue(':searchTitle', '%' . $searchTitle . '%');
}

$stmt->execute();

$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Event List</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
<nav class="navbar">
    <div class="logo">
        <h1>FarhaEvents</h1>
    </div>
    <div class="nav-links">
        <a href="#Home">Home</a>
        <a href="details.php">YourEvents</a>
        <a href="#Contact">Contact</a>
    </div>
</nav>


<form method="POST" action="" style="text-align: center; margin-top: 20px;;">
    <input type="text" name="searchTitle" placeholder="Search by event title..." value="<?= htmlspecialchars($searchTitle) ?>">
    <button type="submit" style="background:pink">Search </button>
</form>

<div class="event-cards">
    <?php if (count($rows) > 0): ?>
        <?php foreach ($rows as $row): ?>
            <div class="card">
                <img src="<?= $row['image'] ?>" alt="Event Image">
                <h3><?= $row['eventTitle'] ?></h3>
                <p>Date: <?= $row['dateEvent'] ?></p>
                <p>Time: <?= $row['timeEvent'] ?></p>
                <p>Category: <?= $row['eventType'] ?></p>

                <form method="POST" action="details.php">
                    <input type="hidden" name="eventId" value="<?= $row['eventId'] ?>">
                    <button type="submit">Details</button>
                </form>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No events found matching your search.</p>
    <?php endif; ?>
</div>

</body>
</html>
