<?php
session_start();
include 'connection.php';

$successMessage = $errorMessage = "";


$custID = $_SESSION['custID'];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $custName = htmlspecialchars($_POST['custName']);
    $rating = htmlspecialchars($_POST['rating']);
    $descReview = htmlspecialchars($_POST['comment']);

    // Handle image upload
    $targetDir = "../uploads/"; // Folder to store uploaded images
    $imageFileName = basename($_FILES["reviewImage"]["name"]);
    $targetFilePath = $targetDir . $imageFileName;
    $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

    // Validate image file type
    $allowedTypes = ["jpg", "jpeg", "png", "gif"];
    if (in_array($imageFileType, $allowedTypes)) {
        if (move_uploaded_file($_FILES["reviewImage"]["tmp_name"], $targetFilePath)) {
            // Insert review into the database
            $stmt = $conn->prepare("INSERT INTO review (custName, rating, image, descReview, custID) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sissi", $custName, $rating, $imageFileName, $descReview, $custID);

            if ($stmt->execute()) {
                $successMessage = "Review submitted successfully!";
            } else {
                $errorMessage = "Error submitting review. Please try again.";
            }
            $stmt->close();
        } else {
            $errorMessage = "Sorry, there was an error uploading your file.";
        }
    } else {
        $errorMessage = "Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Page</title>
    <link rel="stylesheet" href="index-style.css">
    <link rel="stylesheet" href="review.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="images/logo.png" alt="Virtual Try On Logo">
        </div>
        <div class="search-bar">
            <input type="text" placeholder="Search By Typing Keywords...">
        </div>
        <div class="account">
            <img src="images/account-logo.png" alt="Account Icon">
            <a href="userprofile.php"><span>Account</span> </a>
        </div>
    </header>

    <nav>
        <ul>
             <li><a href="index.php">Home</a></li>
            <li><a href="category.php">Category</a></li>
            <li><a href="tryOn.php">Virtual Try On</a></li>
            <li><a href="review.php" class="active">Review</a></li>
        </ul>
    </nav>

    <main>
        <section class="review-container">
            <div class="review-form">
                <?php if (!empty($successMessage)) : ?>
                    <p class="success"><?php echo $successMessage; ?></p>
                <?php elseif (!empty($errorMessage)) : ?>
                    <p class="error"><?php echo $errorMessage; ?></p>
                <?php else : ?>
                    <form action="review.php" method="post" enctype="multipart/form-data">
                        <h3>Name</h3>
                        <input type="text" name="custName" placeholder="Enter your name" required>

                        <h3>Rating</h3>
                        <input type="number" name="rating" min="1" max="5" placeholder="Rate 1-5" required>

                        <h3>Comment</h3>
                        <textarea name="comment" placeholder="Write your review here..." required></textarea>

                        <h3>Upload Image</h3>
                        <input type="file" name="reviewImage" accept="image/*" required>

                        <br>
                        <div class="button-container">
                            <button type="submit" class="submit-btn">Submit</button>
                            <a href="review-list.php"><button type="button" class="see-review-btn">View Reviews</button></a>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </section>
    </main>
</body>
</html>
