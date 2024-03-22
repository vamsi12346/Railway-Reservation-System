<?php

// Assuming you have a database connection in $pdo

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Read input parameters
        $origin = $_POST['origin'];
        $destination = $_POST['destination'];

        // Prepare SQL queries
        $stmtOrigin = $pdo->prepare("SELECT * FROM trainstimings WHERE location = ?");
        $stmtDestination = $pdo->prepare("SELECT * FROM trainstimings WHERE location = ?");
        $stmtOrigin->execute([$origin]);
        $stmtDestination->execute([$destination]);

        // Fetch data
        $orgindata = $stmtOrigin->fetchAll(PDO::FETCH_ASSOC);
        $destinationdata = $stmtDestination->fetchAll(PDO::FETCH_ASSOC);

        // Process data
        $data = [];
        foreach ($orgindata as $train1) {
            foreach ($destinationdata as $train2) {
                if ($train1['id'] === $train2['id']) {
                    if ($train1['hours'] < $train2['hours']) {
                        $data[] = [
                            'trainno' => $train1['id'],
                            'origin' => $train1['location'],
                            'destination' => $train2['location'],
                            'departure' => ['hours' => $train1['hours'], 'minutes' => $train1['minutes']],
                            'arrival' => ['hours' => $train2['hours'], 'minutes' => $train2['minutes']],
                        ];
                    } elseif ($train1['hours'] === $train2['hours'] && $train1['minutes'] < $train2['minutes']) {
                        $data[] = [
                            'trainno' => $train1['trainno'],
                            'origin' => $train1['location'],
                            'destination' => $train2['location'],
                            'departure' => $train2['time'],
                            'arrival' => $train1['time'],
                        ];
                    }
                }
            }
        }

        // Return data as JSON
        header('Content-Type: application/json');
        echo json_encode($data);

    } catch (PDOException $e) {
        http_response_code(500);
        echo "Server Error";
        exit;
    }
}

?>
