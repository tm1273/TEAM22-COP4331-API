<?php
    $inData = getRequestInfo();

    $userId = $inData["userId"];
    $name = $inData["Name"];

    // Database connection
    $conn = new mysqli("localhost", "TheBeast", "WeLoveCOP4331", "COP4331");

    if ($conn->connect_error)
    {
        returnWithError($conn->connect_error);
    }
    else
    {
        // Prepare statement
        $stmt = $conn->prepare("DELETE FROM Contacts WHERE Name = ? AND UserID = ?");
        if (!$stmt) {
            returnWithError($conn->error);
        } else {
            $stmt->bind_param("si", $name, $userId);
            $stmt->execute();
            $stmt->close();
        }
        $conn->close();
    }

    function getRequestInfo()
    {
        return json_decode(file_get_contents('php://input'), true);
    }

    function sendResultInfoAsJson($obj)
    {
        header('Content-type: application/json');
        echo $obj;
    }

    function returnWithError($err)
    {
        $retValue = '{"error":"' . $err . '"}';
        sendResultInfoAsJson($retValue);
    }
?>
