<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// আপনার ডাটাবেজ তথ্য
$host = "panel.garudacloud.in"; // অথবা রিমোট হোস্ট
$user = "u1511_gC7Q5bnPMS"; // আপনার ইউজার
$pass = "r=D3YJ.IEcq@la55pkMxgV2A"; // আপনার পাসওয়ার্ড
$dbname = "s1511_Fuck";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    echo json_encode(["error" => "Database connection failed"]);
    exit();
}

// টপ ৫ রিচ প্লেয়ার কুয়েরি (আপনার টেবিল ও কলামের নাম অনুযায়ী পরিবর্তন করবেন)
$sql = "SELECT username, cash, bank, score FROM players ORDER BY (cash + bank) DESC LIMIT 5";
$result = $conn->query($sql);

$topPlayers = [];
$rank = 1;

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $totalMoney = $row['cash'] + $row['bank'];
        $topPlayers[] = [
            "rank" => $rank++,
            "name" => $row['username'],
            "faction" => "Citizen",
            "networth" => "$" . number_format($totalMoney),
            "level" => (int)$row['score'],
            "online" => false
        ];
    }
}

// আউটপুট
echo json_encode([
    "onlinePlayers" => 0, // স্যাম্প কোয়েরি বা অনলাইন কাউন্ট
    "uptime" => "24/7 Online",
    "topPlayers" => $topPlayers
]);

$conn->close();
?>
