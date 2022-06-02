<?php
if (isset($_POST['submit'])) {
    if (isset($_POST['username']) && isset($_POST['password']) &&
        isset($_POST['gen']) && isset($_POST['email']) &&
        isset($_POST['phoneCode']) && isset($_POST['phone'])) {
        
        $username = $_POST['username'];
        $password = $_POST['password'];
        $gen = $_POST['gen'];
        $email = $_POST['email'];
        $phoneCode = $_POST['phoneCode'];
        $phone = $_POST['phone'];
        $host = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbName = "youtube";
        $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
        if ($conn->connect_error) {
            die('Nu te poti conecta la baza de date.');
        }
        else {
            $Select = "SELECT email FROM register WHERE email = ? LIMIT 1";
            $Insert = "INSERT INTO register(username, password, gen, email, phoneCode, phone) values(?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($Select);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($resultEmail);
            $stmt->store_result();
            $stmt->fetch();
            $rnum = $stmt->num_rows;
            if ($rnum == 0) {
                $stmt->close();
                $stmt = $conn->prepare($Insert);
                $stmt->bind_param("ssssii",$username, $password, $gen, $email, $phoneCode, $phone);
                if ($stmt->execute()) {
                    echo "Înregistrare nouă a fost inserată cu succes.";
                }
                else {
                    echo $stmt->error;
                }
            }
            else {
                echo "Cineva se înregistrează deja folosind acest e-mail.";
            }
            $stmt->close();
            $conn->close();
        }
    }
    else {
        echo "Toate câmpurile sunt obligatorii.";
        die();
    }
}
else {
    echo "Butonul de trimitere nu este setat";
}
?>