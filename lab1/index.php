<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Lab1</title>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js">
    </script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js">
    </script>


    <style>
        #zinutes {
            font-family: Arial;
            border-collapse: collapse;
            width: 70%;
        }

        #zinutes td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #zinutes tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #zinutes tr:hover {
            background-color: #ddd;
        }
    </style>

</head>

<body>

    <?php
    $server = "localhost";
    $user = "root";
    $password = "";
    $dbname = "stud";
    $lentele = "augustasjakaitis";

    //prisijungti prie db
    $conn = new mysqli($server, $user, $password, $dbname);
    if ($conn->connect_error)
        die("Negaliu prisijungti: " . $conn->connect_error);

    $sql =  "SELECT * FROM $lentele";
    if (!$result = $conn->query($sql))
        die("Negaliu nuskaityti: " . $conn->error);

    if ($_POST != null) {

        $siuntejas = $_POST['siuntejas'];
        $pastas = $_POST['epastas'];
        $gavejas = $_POST['gavejas'];
        $host = $_SERVER['REMOTE_ADDR'];
        $time = date("Y-m-d H:i:s");
        $zinute = htmlspecialchars($_POST['zinute']);

        $sql = "INSERT INTO $lentele (vardas, epastas, kam, data, ip, zinute) 
                  VALUES ('$siuntejas', '$pastas','$gavejas', '$time','$host', '$zinute')";
        if (!$result = $conn->query($sql))
            die("Negaliu įrašyti: " . $conn->error); {
            header("Location:index.php");
            exit;
        }
    }
    $conn->close();
    ?>

    <div class="container">
        <center>
            <h3>Žinučių sistema</h3>
        </center>
        <table style="margin: 0px auto;" id=zinutes class="table table-striped">
            <thead>
                <tr>
                    <th>Nr</th>
                    <th>Kas siuntė</th>
                    <th>Siuntėjo e-paštas</th>
                    <th>Gavėjas</th>
                    <th>Data(IP)</th>
                    <th>Žinutė</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $result->fetch_assoc()) {
                    echo
                        "<tr>
                            <th>" . $row['id'] . "</td>
                            <td>" . $row['vardas'] . "</td>
                            <td>" . $row['epastas'] . "</td>
                            <td>" . $row['kam'] . "</td>
                            <td>" . $row['data'] . " (" . $row['ip'] . ")" . "</td>
                            <td>" . $row['zinute'] . "</td>
                        </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="container">
        <center>
            <h3>Įveskite naują žinutę</h3>
        </center>
        <form method='post'>
            <div class="form-group col-lg-4">
                <label for="siuntejas" class="control-label">Siuntėjo vardas:</label>
                <input name='siuntejas' type='text' class="form-control input-sm">
            </div>
            <div class="form-group col-lg-4">
                <label for="epastas" class="control-label">Siuntėjo e-paštas:</label>
                <input name='epastas' id="epastas" type='email' class="form-control input-sm">
            </div>
            <div class="form-group col-lg-4">
                <label for="gavejas" class="control-label">Kam skirta:</label>
                <input name='gavejas' type='text' class="form-control input-sm">
            </div>
            <div class="form-group col-lg-12">
                <label for="zinute" class="control-label">Žinutė:</label>
                <textarea name='zinute' class="form-control input-sm"></textarea>
            </div>
            <div class="form-group col-lg-2">
                <input type='submit' name='ok' value='siųsti' class="btnbtn-default">
            </div>

        </form>
    </div>


</body>

</html>