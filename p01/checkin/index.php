<?php
$api = getenv('API_URL') ?: 'http://api';
$result = null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $payload = json_encode([
        'booking_reference' => trim($_POST['booking_reference'] ?? ''),
        'passenger_name' => trim($_POST['passenger_name'] ?? '')
    ]);

    $ch = curl_init($api . '/checkin');
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $payload,
        CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 5
    ]);
    $response = curl_exec($ch);
    curl_close($ch);

    if ($response === false) {
        $error = 'Airport API is unavailable.';
    } else {
        $data = json_decode($response, true);
        if (($data['success'] ?? false) === true) $result = $data;
        else $error = $data['message'] ?? 'Passenger data was not found.';
    }
}
?>
<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Passenger Check-in</title><link rel="stylesheet" href="style.css"></head>
<body>
<header><div><strong>XYZ AIRPORT</strong><small>Passenger Check-in System</small></div><a href="http://localhost:8080">← Portal</a></header>
<main>
<div class="heading"><p>PASSENGER SERVICE</p><h1>Passenger Check-in</h1><span>Enter your booking information</span></div>
<div class="layout">
<section class="panel">
<form method="post">
<label>Booking Reference<input name="booking_reference" placeholder="e.g. ABC123" required></label>
<label>Passenger Name<input name="passenger_name" placeholder="e.g. Ahmad" required></label>
<button type="submit">Check in passenger</button>
</form>
<div class="sample"><strong>Training data</strong><br>ABC123 / Ahmad<br>DEF456 / Siti<br>GHI789 / Budi<br>JKL012 / Rina</div>
</section>
<section>
<?php if ($result): ?>
<div class="success"><div class="check">✓</div><p>CHECK-IN SUCCESSFUL</p><h2><?= htmlspecialchars($result['passenger']['name']) ?></h2><div class="ticket"><span>FLIGHT<strong><?= htmlspecialchars($result['passenger']['flight']) ?></strong></span><span>DESTINATION<strong><?= htmlspecialchars($result['passenger']['destination']) ?></strong></span><span>SEAT<strong><?= htmlspecialchars($result['passenger']['seat']) ?></strong></span></div></div>
<?php elseif ($error): ?><div class="error"><?= htmlspecialchars($error) ?></div><?php else: ?><div class="empty">Check-in result will appear here.</div><?php endif; ?>
</section>
</div>
<div class="lab-note"><strong>Lab observation:</strong> The Check-in application sends the passenger request to the Airport API. The API is the component that communicates with MariaDB.</div>
</main>
</body></html>