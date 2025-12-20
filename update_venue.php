<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "goevent_db");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$venues_result = mysqli_query($conn, "SELECT * FROM venues ORDER BY name");

$message = "";
$selected_venue = null;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['venue_id'])) {
    $venue_id = mysqli_real_escape_string($conn, $_POST['venue_id']);
    
    if (isset($_POST['fetch'])) {
        $sql = "SELECT * FROM venues WHERE venue_id = '$venue_id'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $selected_venue = mysqli_fetch_assoc($result);
        }
    } elseif (isset($_POST['update'])) {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $capacity = mysqli_real_escape_string($conn, $_POST['capacity']);
        $facilities = mysqli_real_escape_string($conn, $_POST['facilities']);
        $location = mysqli_real_escape_string($conn, $_POST['location']);
        
        $sql = "UPDATE venues SET 
                name = '$name',
                capacity = '$capacity',
                facilities = '$facilities',
                location = '$location'
                WHERE venue_id = '$venue_id'";
        
        if (mysqli_query($conn, $sql)) {
            $message = "<div class='alert alert-success'>Venue updated successfully!</div>";
            $venues_result = mysqli_query($conn, "SELECT * FROM venues ORDER BY name");
        } else {
            $message = "<div class='alert alert-danger'>Error updating venue: " . mysqli_error($conn) . "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Venue - GoEvent</title>
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
            <li class="nav-item"><a class="nav-link" href="insert_event.php">Insert Event</a></li>
            <li class="nav-item"><a class="nav-link active" href="update_venue.php">Update Venue</a></li>
            <li class="nav-item"><a class="nav-link" href="delete_booking.php">Delete Booking</a></li>
        </ul>
    </div>
</nav>

<div class="container my-5">
    <h1 class="mb-4">Update Venue Information</h1>
    
    <?php echo $message; ?>
    
    <form method="POST" action="" class="row g-3 mb-4">
        <div class="col-md-8">
            <label for="venue_id" class="form-label">Select Venue to Update:</label>
            <select class="form-select" id="venue_id" name="venue_id" required>
                <option value="">-- Select a Venue --</option>
                <?php
                if (mysqli_num_rows($venues_result) > 0) {
                    mysqli_data_seek($venues_result, 0);
                    while($venue = mysqli_fetch_assoc($venues_result)) {
                        $selected = ($selected_venue && $selected_venue['venue_id'] == $venue['venue_id']) ? 'selected' : '';
                        echo "<option value='{$venue['venue_id']}' $selected>{$venue['name']} - {$venue['location']}</option>";
                    }
                }
                ?>
            </select>
        </div>
        <div class="col-md-4 d-flex align-items-end">
            <button type="submit" name="fetch" class="btn btn-info w-100">Load Venue Details</button>
        </div>
    </form>
    
    <?php if ($selected_venue): ?>
    <form method="POST" action="" class="row g-3">
        <input type="hidden" name="venue_id" value="<?php echo $selected_venue['venue_id']; ?>">
        
        <div class="col-md-6">
            <label for="name" class="form-label">Venue Name</label>
            <input type="text" class="form-control" id="name" name="name" 
                   value="<?php echo htmlspecialchars($selected_venue['name']); ?>" required>
        </div>
        
        <div class="col-md-6">
            <label for="capacity" class="form-label">Capacity</label>
            <input type="text" class="form-control" id="capacity" name="capacity" 
                   value="<?php echo htmlspecialchars($selected_venue['capacity']); ?>" required>
        </div>
        
        <div class="col-12">
            <label for="facilities" class="form-label">Facilities</label>
            <textarea class="form-control" id="facilities" name="facilities" rows="3" required><?php echo htmlspecialchars($selected_venue['facilities']); ?></textarea>
        </div>
        
        <div class="col-12">
            <label for="location" class="form-label">Location</label>
            <input type="text" class="form-control" id="location" name="location" 
                   value="<?php echo htmlspecialchars($selected_venue['location']); ?>" required>
        </div>
        
        <div class="col-12">
            <button type="submit" name="update" class="btn btn-primary">Update Venue</button>
            <a href="update_venue.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
    <?php endif; ?>
    
    <hr class="my-4">
    
    <h3 class="mt-5">Current Venues in Database</h3>
    <?php
    mysqli_data_seek($venues_result, 0);
    if (mysqli_num_rows($venues_result) > 0) {
        echo "<table class='table table-striped'>
                <thead><tr>
                    <th>ID</th><th>Name</th><th>Capacity</th>
                    <th>Facilities</th><th>Location</th>
                </tr></thead><tbody>";
        mysqli_data_seek($venues_result, 0);
        while($venue = mysqli_fetch_assoc($venues_result)) {
            echo "<tr>
                    <td>{$venue['venue_id']}</td>
                    <td>{$venue['name']}</td>
                    <td>{$venue['capacity']}</td>
                    <td>" . substr($venue['facilities'], 0, 50) . "...</td>
                    <td>{$venue['location']}</td>
                  </tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<p>No venues found in database.</p>";
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