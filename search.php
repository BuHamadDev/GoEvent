<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search - GoEvent</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .search-result {
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
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
            <li class="nav-item"><a class="nav-link active" href="search.php">Search</a></li>
            <li class="nav-item"><a class="nav-link" href="insert_event.php">Insert Event</a></li>
            <li class="nav-item"><a class="nav-link" href="update_venue.php">Update Venue</a></li>
            <li class="nav-item"><a class="nav-link" href="delete_booking.php">Delete Booking</a></li>
        </ul>
    </div>
</nav>

<div class="container my-5">
    <h1 class="mb-4">Search Database</h1>
    
    <!-- Search Form -->
    <form method="GET" action="" class="row g-3 mb-4">
        <div class="col-md-6">
            <label for="search_type" class="form-label">Search In:</label>
            <select id="search_type" name="type" class="form-select" required>
                <option value="events">Events</option>
                <option value="venues">Venues</option>
                <option value="bookings">Bookings</option>
            </select>
        </div>
        
        <div class="col-md-6">
            <label for="search_term" class="form-label">Search Term:</label>
            <input type="text" id="search_term" name="q" class="form-control" 
                   placeholder="Enter keyword to search..." required>
        </div>
        
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Search</button>
            <a href="search.php" class="btn btn-secondary">Clear</a>
        </div>
    </form>

    <?php
    $conn = mysqli_connect("localhost", "root", "", "goevent_db");
    if (!$conn) {
        die("<div class='alert alert-danger'>Connection failed: " . mysqli_connect_error() . "</div>");
    }

    if (isset($_GET['q']) && !empty($_GET['q'])) {
        $search_type = mysqli_real_escape_string($conn, $_GET['type']);
        $search_term = mysqli_real_escape_string($conn, $_GET['q']);
        
        echo "<h3>Search Results for '$search_term' in $search_type:</h3>";
        
        switch($search_type) {
            case 'events':
                $sql = "SELECT * FROM events WHERE 
                        name LIKE '%$search_term%' OR 
                        category LIKE '%$search_term%' OR 
                        venue LIKE '%$search_term%'";
                $result = mysqli_query($conn, $sql);
                
                if (mysqli_num_rows($result) > 0) {
                    echo "<table class='table table-striped'>
                            <thead><tr>
                                <th>ID</th><th>Event Name</th><th>Category</th>
                                <th>Date</th><th>Venue</th>
                            </tr></thead><tbody>";
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                                <td>{$row['event_id']}</td>
                                <td>{$row['name']}</td>
                                <td>{$row['category']}</td>
                                <td>{$row['date']}</td>
                                <td>{$row['venue']}</td>
                              </tr>";
                    }
                    echo "</tbody></table>";
                } else {
                    echo "<div class='alert alert-info'>No events found matching your search.</div>";
                }
                break;
                
            case 'venues':
                $sql = "SELECT * FROM venues WHERE 
                        name LIKE '%$search_term%' OR 
                        location LIKE '%$search_term%' OR 
                        facilities LIKE '%$search_term%'";
                $result = mysqli_query($conn, $sql);
                
                if (mysqli_num_rows($result) > 0) {
                    echo "<table class='table table-striped'>
                            <thead><tr>
                                <th>ID</th><th>Venue Name</th><th>Capacity</th>
                                <th>Location</th><th>Facilities</th>
                            </tr></thead><tbody>";
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                                <td>{$row['venue_id']}</td>
                                <td>{$row['name']}</td>
                                <td>{$row['capacity']}</td>
                                <td>{$row['location']}</td>
                                <td>{$row['facilities']}</td>
                              </tr>";
                    }
                    echo "</tbody></table>";
                } else {
                    echo "<div class='alert alert-info'>No venues found matching your search.</div>";
                }
                break;
                
            case 'bookings':
                $sql = "SELECT * FROM bookings WHERE 
                        event LIKE '%$search_term%' OR 
                        name LIKE '%$search_term%' OR 
                        email LIKE '%$search_term%'";
                $result = mysqli_query($conn, $sql);
                
                if (mysqli_num_rows($result) > 0) {
                    echo "<table class='table table-striped'>
                            <thead><tr>
                                <th>ID</th><th>Event</th><th>Name</th>
                                <th>Email</th><th>Ticket Type</th><th>Quantity</th>
                            </tr></thead><tbody>";
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                                <td>{$row['booking_id']}</td>
                                <td>{$row['event']}</td>
                                <td>{$row['name']}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['ticket_type']}</td>
                                <td>{$row['quantity']}</td>
                              </tr>";
                    }
                    echo "</tbody></table>";
                } else {
                    echo "<div class='alert alert-info'>No bookings found matching your search.</div>";
                }
                break;
        }
        
        mysqli_free_result($result);
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