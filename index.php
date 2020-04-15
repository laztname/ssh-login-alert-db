<?php
include_once("config_db.php");
$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DATABASE);
if($conn->connect_error)
{
        die("Connection failed: " .$conn->connect_error);
}
?>
<!DOCTYPE html>

<head>
    <title>SSH Monitoring Log</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
</head>

<body>
    <header>
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#Navbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/">SSH Log Monitoring</a>
                </div>

                <div class="collapse navbar-collapse" id="Navbar">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="nav-item">
                            <input type="button" class="navbar-btn btn navbar-nav" value="Refresh Now" id=refresh>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main role="main">
        <div class="container" style="padding-top:80px">

            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#listserv">List</a></li>
                <li><a data-toggle="tab" href="#log">Log</a></li>
            </ul>
            <div class="row">
                <div class="tab-content">
                    <div id="listserv" class="tab-pane fade in active">
                        <h3>List Server and Last Log</h3>
                        <p>Menampilkan data seluruh server yang telah terinstall log monitor ssh dan user dan client IP yang terakhir masuk</p>
                        <div class="col-12 col-sm-12 col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered list" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Hostname</th>
                                            <th>IP Server</th>
                                            <th>Username</th>
                                            <th>IP User</th>
                                            <th>Date time</th>
                                        </tr>
                                    </thead>
                                    <tbody>

<?php
$sql = "SELECT DISTINCT remote_ip from users ORDER BY remote_hostname ASC";
$res = $conn->query($sql);
$no = 1;
while ($row = $res->fetch_assoc())
{
	$sel = "SELECT DISTINCT * FROM users where remote_ip = '".$row['remote_ip']."' limit 1";
	$rest = $conn->query($sel);
	while ($data = $rest->fetch_assoc())
	{
		//var_dump($data);
		echo "<tr>";
		echo "<td>".$no++."</td>";
		echo "<td>".$data['remote_hostname']."</td>";
		echo "<td>".$data['remote_ip']."</td>";
		echo "<td>".$data['username']."</td>";
		echo "<td>".$data['user_ip']."</td>";
		echo "<td>".$data['date']."</td>";
		echo "</tr>";

	}
}
?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
<?php
$sql = "SELECT * FROM users";
$res = $conn->query($sql);
?>
                    <div id="log" class="tab-pane fade">
                        <h3>All Server Logs</h3>
                        <p>Menampilkan data seluruh log user yang masuk ke server</p>
                        <div class="col-12 col-sm-12 col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered list" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Hostname</th>
                                            <th>IP Server</th>
                                            <th>Username</th>
                                            <th>IP User</th>
                                            <th>Date time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
while ($row = $res->fetch_assoc())
{
	echo "<tr>";
	echo "<td>".$row['id']."</td>";
	echo "<td>".$row['remote_hostname']."</td>";
	echo "<td>".$row['remote_ip']."</td>";
	echo "<td>".$row['username']."</td>";
	echo "<td>".$row['user_ip']."</td>";
	echo "<td>".$row['date']."</td>";
	echo "</tr>";
}

?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

</body>

<script src="assets/js/jquery.min.js"></script>
<script>
$(document).ready( function () {
	$('.list').DataTable();
});
</script>

<script src="assets/js/bootstrap.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>

</html>
<?php
mysqli_close($conn);
?>
