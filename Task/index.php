<?php
declare(strict_types=1);

// App File Imports
include './Inc/app_init.php';
include './Inc/chronik.php';

// Fetch all employees sorted by last name
function get_Appdata(): array
{
    $init = new AppInit();
    $employees = $init->getAllEmployees();

    return $employees;
}

$init_app = get_Appdata();

function get_chronik_data():array
{
    $chronik = new Chronik();
    $chronik_data = $chronik->get_chronik_data();

    return $chronik_data;
}
get_chronik_data();

$tableheader_columns = $init_app['tableheader'];
$employees_data = $init_app['employee_data'];


$test = [1,2,3,4,5];


?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./Assets/CSS/style.css">
    <title>Mitarbeiter Verwaltungs Tool</title>
</head>

<body>
    <main>
        <section>
            <div class="chronik">
                <div class="headline">
                    <h2>Chronik der Wochenstunden</h2>
                    <span class="close">&times;</span>
                </div>
                <div class="chronik-content">
                    <div class="chronik-content-1">
                        <div class="headline">
                            <h2>Chronik der Wochenstunden</h2>
                            <span class="close">&times;</span>
                        </div>
                        <div class="box">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Gültig-Ab Datum</th>
                                        <th>Wochenstunden</th>
                                        <th>Änderung gemacht durch</th>
                                    </tr>
                                </thead>
                                <tbody id="chronik-table">
                                    <tr>
                                        <td>01.01.2021</td>
                                        <td>40h</td>
                                        <td>Max Mustermann</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div>
                            <h2>Änderungen</h2>
                            <div>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Letzte Änderung der Wochenstunden</th>
                                            <th>Alter Wert</th>
                                            <th>Neuer Wert</th>
                                        </tr>
                                    </thead>
                                    <tbody id="chronik-changes-table">
                                        <tr>
                                            <td>01.01.2021</td>
                                            <td>40h</td>
                                            <td>38h</td>
                                        </tr>
                                        <tr>
                                            <td>01.01.2021</td>
                                            <td>40h</td>
                                            <td>38h</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="chronik-content-2">
                        <div class="box">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Gültig-Ab Datum</th>
                                        <th>Wochenstunden</th>
                                        <th>Änderung gemacht durch</th>
                                    </tr>
                                </thead>
                                <tbody id="chronik-table">
                                    <tr>
                                        <td>01.01.2021</td>
                                        <td>40h</td>
                                        <td>Max Mustermann</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div>
                            <h2>Änderungen</h2>
                            <div>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Letzte Änderung der Wochenstunden</th>
                                            <th>Alter Wert</th>
                                            <th>Neuer Wert</th>
                                        </tr>
                                    </thead>
                                    <tbody id="chronik-changes-table">
                                        <tr>
                                            <td>01.01.2021</td>
                                            <td>40h</td>
                                            <td>38h</td>
                                        </tr>
                                        <tr>
                                            <td>01.01.2021</td>
                                            <td>40h</td>
                                            <td>38h</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <h1> Mitarbeiter Verwaltungs Tool</h1>
            <div class="table-box">
                <table>
                    <thead>
                        <tr>
                            <?php foreach ($tableheader_columns as $value) : ?>
                                <th><?= $value ?></th>
                            <?php endforeach; ?>
                            <th>Chronik</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($employees_data as $array_key => $value_arrays) :
                            $ma_id = $value_arrays['staffId'];
                            $start_date = $value_arrays['startDate'];
                            $end_date = $value_arrays['endDate'] ?? null;
                            $weekly_hours = $value_arrays['weeklyHours'];
                            $update_date = $value_arrays['updateDate'];
                            $name = $value_arrays['name'];
                        ?>
                        <tr>
                            <td><b><?= $name ?></b></td>
                            <td><?= date("d.m.Y", strtotime($start_date)) ?></td>
                            <?php if (!empty($end_date)) : ?>
                                <td><?= date("d.m.Y", strtotime($end_date)) ?></td>
                            <?php else : ?>
                                <td> - </td>
                            <?php endif; ?>
                            <td><b><?= $weekly_hours ?>h</b></td>
                            <td><?= date("d.m.Y / H:i:s", strtotime($update_date))  ?></td>
                            <td>
                                <button data-btn="ma-id-<?= $ma_id ?>" class="btn" id="btn-<?= $ma_id ?>">
                                    <span>Chronik anzeigen</span>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>

    </main>
</body>

<script src="./Assets/JS/script.js"></script>

</html>