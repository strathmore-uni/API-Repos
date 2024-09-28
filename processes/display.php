<?php

class display{

public function displayUsers($conn) {
    $sql = "SELECT userId, fullname, username, email FROM users ORDER BY userId ASC";
    $result = $conn->select_while($sql);
 ?>  
        <h3>A list of users details</h3>";
        
<ol>

<?php
foreach ($result as $user) {
    echo "<li>{$user['fullname']} </br>ID: {$user['userId']}</br>Email: {$user['email']}</li>";
}?>
</ol>
<?php
}
}