<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "goevent_db");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['booking_id'])) {
    $booking_id = mysqli_real_escape_string($conn, $_POST['booking_id']);
    
    $sql_select = "SELECT * FROM bookings WHERE booking_id = '$booking_id'";
    $result = mysqli_query($conn, $sql_select);
    
    if (mysqli_num_rows($result) > 0) {
        $booking = mysqli_fetch_assoc($result);
        
        $sql_delete = "DELETE FROM bookings WHERE booking_id = '$booking_id'";
        
        if (mysqli_query($conn, $sql_delete)) {
            $message = "<div class='alert alert-success'>Booking deleted successfully!<br>
                        Deleted Booking: {$booking['event']} by {$booking['name']}</div>";
        } else {
            $message = "<div class='alert alert-danger'>Error deleting booking: " . mysqli_error($conn) . "</div>";
        }
    } else {
        $message = "<div class='alert alert-warning'>Booking ID not found!</div>";
    }
}

$bookings_result = mysqli_query($conn, "SELECT * FROM bookings ORDER BY booking_id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Booking - GoEvent</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .delete-btn {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
        }
        .delete-btn:hover {
            background-color: #c82333;
        }
    </style>
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
            <li class="nav-item"><a class="nav-link" href="update_venue.php">Update Venue</a></li>
            <li class="nav-item"><a class="nav-link active" href="delete_booking.php">Delete Booking</a></li>
        </ul>
    </div>
</nav>

<div class="container my-5">
    <h1 class="mb-4">Delete Booking</h1>
    
    <?php echo $message; ?>
    
    <form method="POST" action="" class="row g-3 mb-4" onsubmit="return confirmDelete()">
        <div class="col-md-8">
            <label for="booking_id" class="form-label">Select Booking ID to Delete:</label>
            <select class="form-select" id="booking_id" name="booking_id" required>
                <option value="">-- Select Booking ID --</option>
                <?php
                if (mysqli_num_rows($bookings_result) > 0) {
                    mysqli_data_seek($bookings_result, 0);
                    while($booking = mysqli_fetch_assoc($bookings_result)) {
                        echo "<option value='{$booking['booking_id']}'>
                                #{$booking['booking_id']} - {$booking['event']} ({$booking['name']})
                              </option>";
                    }
                }
                ?>
            </select>
        </div>
        <div class="col-md-4 d-flex align-items-end">
            <button type="submit" class="btn btn-danger w-100">Delete Booking</button>
        </div>
    </form>
    
    <h3 class="mt-5">Current Bookings</h3>
    <?php
    mysqli_data_seek($bookings_result, 0);
    if (mysqli_num_rows($bookings_result) > 0) {
        echo "<table class='table table-striped'>
                <thead><tr>
                    <th>Booking ID</th><th>Event</th><th>Name</th>
                    <th>Email</th><th>Ticket Type</th><th>Quantity</th>
                    <th>Action</th>
                </tr></thead><tbody>";
        
        mysqli_data_seek($bookings_result, 0);
        while($booking = mysqli_fetch_assoc($bookings_result)) {
            echo "<tr>
                    <td>{$booking['booking_id']}</td>
                    <td>{$booking['event']}</td>
                    <td>{$booking['name']}</td>
                    <td>{$booking['email']}</td>
                    <td>{$booking['ticket_type']}</td>
                    <td>{$booking['quantity']}</td>
                    <td>
                        <form method='POST' action='' style='display:inline;' onsubmit='return confirmDelete()'>
                            <input type='hidden' name='booking_id' value='{$booking['booking_id']}'>
                            <button type='submit' class='delete-btn'>Delete</button>
                        </form>
                    </td>
                  </tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<div class='alert alert-info'>No bookings found in database.</div>";
    }
    
    mysqli_close($conn);
    ?>
</div>

<footer class="bg-primary text-white text-center py-3">
    <p class="mb-0">&copy; 2025 GoEvent. All rights reserved.</p>
    <p class="mb-0">Discover. Join. Connect.</p>
</footer>

<script>
function confirmDelete() {
    return confirm("Are you sure you want to delete this booking? This action cannot be undone.");
}
</script>

</body>
</html>