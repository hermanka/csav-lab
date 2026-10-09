<?php
header('Content-Type: application/json');

$host = getenv('DB_HOST') ?: 'db';
$port = getenv('DB_PORT') ?: '3306';
$name = getenv('DB_NAME') ?: 'airport';
$user = getenv('DB_USER') ?: 'airport';
$pass = getenv('DB_PASSWORD') ?: 'airport';

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$name;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (Exception $e) {
    http_response_code(503);
    echo json_encode(['error' => 'Database unavailable']);
    exit;
}

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($path === '/health') {
    echo json_encode(['status' => 'ok']);
    exit;
}

if ($path === '/flights') {
    $stmt = $pdo->query("SELECT flight_number, destination, gate, departure_time, status FROM flights ORDER BY departure_time");
    echo json_encode($stmt->fetchAll());
    exit;
}

if ($path === '/checkin') {
    $input = json_decode(file_get_contents('php://input'), true);
    $booking = trim($input['booking_reference'] ?? '');
    $passenger = trim($input['passenger_name'] ?? '');

    $stmt = $pdo->prepare(
        "SELECT p.name, p.booking_reference, p.seat, f.flight_number, f.destination
         FROM passengers p JOIN flights f ON p.flight_id=f.id
         WHERE p.booking_reference=? AND p.name=? LIMIT 1"
    );
    $stmt->execute([$booking, $passenger]);
    $row = $stmt->fetch();

    if (!$row) {
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'Booking reference or passenger name is incorrect.']);
        exit;
    }

    echo json_encode(['success' => true, 'passenger' => [
        'name' => $row['name'],
        'booking_reference' => $row['booking_reference'],
        'flight' => $row['flight_number'],
        'destination' => $row['destination'],
        'seat' => $row['seat']
    ]]);
    exit;
}

http_response_code(404);
echo json_encode(['error' => 'Endpoint not found']);
