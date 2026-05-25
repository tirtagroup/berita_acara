<?php
$conn = new mysqli('cpanel.tirtagroup.net', 'tirt3038', 'Tirtaxx##123', 'tirt3038_HR_Worksheet');
$result = $conn->query('SELECT * FROM Tr_Ba_Main_New WHERE Tr_BA_Main_Code = "BA-20260525181933-2604"');
if ($row = $result->fetch_assoc()) {
  echo "Data Found:\n";
  foreach($row as $key => $val) {
    echo $key . ': ' . ($val ?? 'NULL') . "\n";
  }
} else {
  echo 'No data found';
}
