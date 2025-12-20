<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "goevent_db");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $time = mysqli_real_escape_string($conn, $_POST['time']);
    $venue = mysqli_real_escape_string($conn, $_POST['venue']);
    $image = "images/default.jpg"; 
    
    $sql = "INSERT INTO events (image, name, category, date, time, venue, link) 
            VALUES ('$image', '$name', '$category', '$date', '$time', '$venue', 'event-details.html')";
    
    if (mysqli_query($conn, $sql)) {
        $message = "<div class='alert alert-success'>Event added successfully! Event ID: " . mysqli_insert_id($conn) . "</div>";
    } else {
        $message = "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Insert Event - GoEvent</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="index.html">
            <img src="images/GoEventLogo.jpg" alt="GoEvent Logo" width="50">
        </a>
        <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link" href="index.html">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="search.php">Search</a></li>
            <li class="nav-item"><a class="nav-link active" href="insert_event.php">Insert Event</a></li>
            <li class="nav-item"><a class="nav-link" href="update_venue.php">Update Venue</a></li>
            <li class="nav-item"><a class="nav-link" href="delete_booking.php">Delete Booking</a></li>
        </ul>
    </div>
</nav>

<div class="container my-5">
    <h1 class="mb-4">Add New Event to Database</h1>
    
    <?php echo $message; ?>
    
    <form method="POST" action="" class="row g-3">
        <div class="col-md-6">
            <label for="name" class="form-label">Event Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        
        <div class="col-md-6">
            <label for="category" class="form-label">Category</label>
            <select class="form-select" id="category" name="category" required>
                <option value="">Select Category</option>
                <option value="Conference">Conference</option>
                <option value="Workshop">Workshop</option>
                <option value="Seminar">Seminar</option>
                <option value="Networking">Networking</option>
                <option value="Campus">Campus Event</option>
                <option value="Technology">Technology</option>
                <option value="Sports">Sports</option>
                <option value="Cultural">Cultural</option>
            </select>
        </div>
        
        <div class="col-md-6">
            <label for="date" class="form-label">Date</label>
            <input type="date" class="form-control" id="date" name="date" required>
        </div>
        
        <div class="col-md-6">
            <label for="time" class="form-label">Time</label>
            <input type="time" class="form-control" id="time" name="time" required>
        </div>
        
        <div class="col-12">
            <label for="venue" class="form-label">Venue</label>
            <input type="text" class="form-control" id="venue" name="venue" required>
        </div>
        
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Add Event</button>
            <button type="reset" class="btn btn-secondary">Reset Form</button>
        </div>
    </form>
    
    <hr class="my-4">
    
    <h3 class="mt-5">Current Events in Database</h3>
    <?php
    $sql = "SELECT * FROM events ORDER BY event_id DESC LIMIT 10";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        echo "<table class='table table-striped'>
                <thead><tr>
                    <th>ID</th><th>Name</th><th>Category</th>
                    <th>Date</th><th>Time</th><th>Venue</th>
                </tr></thead><tbody>";
        while($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['event_id']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['category']}</td>
                    <td>{$row['date']}</td>
                    <td>{$row['time']}</td>
                    <td>{$row['venue']}</td>
                  </tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<p>No events found in database.</p>";
    }
    
    mysqli_close($conn);
    ?>
</div>

<footer class="bg-primary text-white text-center py-3">
    <p class="mb-0">&copy; 2025 GoEvent. All rights reserved.</p>
    <p class="mb-0">Discover. Join. Connect.</p>
</footer>

</body>
</html>