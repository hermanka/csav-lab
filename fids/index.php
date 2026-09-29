<?php
$api = getenv('API_URL') ?: 'http://api';
$response = @file_get_contents($api . '/flights');
$flights = $response ? json_decode($response, true) : [];
?>
<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Flight Information</title><link rel="stylesheet" href="style.css"></head>
<body>
<header><div><strong>XYZ AIRPORT</strong><small>Flight Information Display System</small></div><a href="http://localhost:8080">← Portal</a></header>
<main>
<div class="heading"><p>DEPARTURES</p><h1>Flight Information</h1><span>Live data from Airport API</span></div>
<?php if (!$response): ?>
<div class="notice error">Airport API is currently unavailable.</div>
<?php else: ?>
<div class="table-wrap"><table><thead><tr><th>Flight</th><th>Destination</th><th>Gate</th><th>Departure</th><th>Status</th></tr></thead><tbody>
<?php foreach ($flights as $f): ?>
<tr><td><strong><?= htmlspecialchars($f['flight_number']) ?></strong></td><td><?= htmlspecialchars($f['destination']) ?></td><td><?= htmlspecialchars($f['gate']) ?></td><td><?= htmlspecialchars($f['departure_time']) ?></td><td><span class="status"><?= htmlspecialchars($f['status']) ?></span></td></tr>
<?php endforeach; ?>
</tbody></table></div>
<?php endif; ?>
<div class="lab-note"><strong>Lab observation:</strong> This page does not connect directly to the database. It requests flight information from the Airport API.</div>
</main>
</body></html>
