<?php
// Include the database connection file
include '../component/connect.php';

// Check if the review ID is set in the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $reviewID = $_GET['id'];

    // Prepare the delete query using prepared statements for security
    $stmt = $conn->prepare("DELETE FROM review WHERE reviewID = ?");
    $stmt->bind_param("i", $reviewID);

    if ($stmt->execute()) {
        // Success message and redirect
        $stmt->close();
        mysqli_close($conn);
        header("Location: manage-review.php?msg=deleted");
        exit();
    } else {
        // Error handling
        $stmt->close();
        mysqli_close($conn);
        header("Location: manage-review.php?msg=error");
        exit();
    }
} else {
    // If no valid ID, redirect back with an error
    header("Location: manage-review.php?msg=invalid");
    exit();
}
?>
