<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "game_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM leaderboard ORDER BY total_score DESC";
$result = $conn->query($sql);

echo "<h1>Leaderboard</h1>";
if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>Player</th><th>Score</th><th>Date</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["player_name"]. "</td><td>" . $row["total_score"]. "</td><td>" . $row["game_date"]. "</td></tr>";
    }
    echo "</table>";
} else {
    echo "No records found.";
}

$conn->close();
?>
<?php
// get_leaderboard.php

// Database configuration
$host = 'localhost';
$db   = 'game_db';
$user = 'your_db_username';
$pass = 'your_db_password';
$charset = 'utf8mb4';

// Set up DSN
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// Set PDO options
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Enable exceptions
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    // Create PDO instance
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // Handle connection errors
    http_response_code(500);
    echo 'Database connection failed: ' . $e->getMessage();
    exit;
}

try {
    // Fetch top 10 winners ordered by score descending
    $stmt = $pdo->query('SELECT winner_name, score, recorded_at FROM leaderboard ORDER BY score DESC, recorded_at ASC LIMIT 10');
    $leaderboard = $stmt->fetchAll();

    // Return as JSON
    header('Content-Type: application/json');
    echo json_encode($leaderboard);
} catch (\PDOException $e) {
    // Handle SQL errors
    http_response_code(500);
    echo 'Error fetching leaderboard: ' . $e->getMessage();
}
?>
