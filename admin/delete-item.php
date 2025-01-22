<?php
// Start the session
session_start();

// Include the database connection file
include '../component/connect.php'; 

// Fetch itemID from URL query string (GET request)
if (isset($_GET['item-id'])) {
    $itemID = $_GET['item-id'];

    // Query to delete item from the database
    $sql = "DELETE FROM item WHERE itemID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $itemID);  // "i" stands for integer

    if ($stmt->execute()) {
        // Set session variable for success message
        $_SESSION['message'] = "Item deleted successfully.";

        // Redirect to manage-item page after successful deletion
        header("Location: manage-item.php");
        exit; // Make sure the script stops here
    } else {
        echo "Error deleting item: " . $conn->error;
    }

    // Close statement
    $stmt->close();
} else {
    echo "Item ID is required.";
}

// Close the database connection
$conn->close();
?>
