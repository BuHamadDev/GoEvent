<?php

$name = $_POST['name'];
$event = $_POST['event'];
$email = $_POST['email'];
$ticket_type = $_POST['ticket-type'];
$quantity = $_POST['quantity'];
$payment_method = $_POST['payment'];

echo "Booking Successful!<br>";
echo "  <dl>
        <dt>Name: </dt><dd>$name</dd>
        <dt>Event: </dt><dd>$event</dt>
        <dt>Email: </dt><dd>$email</dt>
        <dt>Ticket Type: </dt><dd>$ticket_type</dt>
        <dt>Quantity: </dt><dd>$quantity</dt>
        <dt>Payment Method: </dt><dd>$payment_method</dt>
        </dl>";

class Booking {
    public $name;
    public $email;
    public $event;
    public $ticket_type;
    public $quantity;
    


    public function __construct($name,$email,$event,$ticket_type,$quantity){
        $this->name = $name;
        $this->email = $email;
        $this->event = $event;
        $this->ticket_type = $ticket_type;
        $this->quantity = $quantity;
        
    }
}


$conn = mysqli_connect("localhost", "root", "", "goevent_db");
if (!$conn){
    die("Connection Failed:". mysqli_connect_error());
}

$sql = "SELECT event, ticket_type, quantity, name, email FROM bookings";
$result = mysqli_query($conn, $sql);


$bookings = [];
if ($result -> num_rows >0){
    while ($row = mysqli_fetch_assoc($result)){
        $booking = new Booking(
            $row['name'],
            $row['email'],
            $row['event'],
            $row['ticket_type'],
            $row['quantity']
        );
        array_push($bookings, $booking);
    }
}

function displayBookings($bookings){
    echo '<h2>All Bookings</h2>';
    echo '<table border = "1">
    <tr>
    <th>Name</th>
    <th>Email</th>
    <th>Event</th>
    <th>Ticket Type</th>
    <th>Quantity</th> 
    </tr>';

    foreach ($bookings as $b){
        echo    '<tr>';
        echo    '<td>' . $b->name . '</td>';
        echo    '<td>' . $b->email . '</td>';
        echo    '<td>' . $b->event . '</td>';
        echo    '<td>' . $b->ticket_type . '</td>';
        echo    '<td>' . $b->quantity . '</td>';
        echo    '</tr>';

    }
    echo '</table>';
}

displayBookings($bookings);

mysqli_close($conn);
?>