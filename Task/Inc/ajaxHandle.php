<?php
declare(strict_types=1);

include 'chronik.php';

$get = $_SERVER['REQUEST_URI'];
$get_params_string = explode("?", $get);
$explode_params = explode("&", $get_params_string[1]);
$ma_id = explode("=", $explode_params[0]);
$api_token = explode("=", $explode_params[1]);
$api_key = '1234567890';

if($api_token[1] === $api_key){
    if($ma_id[0] !="id" && $ma_id[1] != "" && $ma_id[1] != null ){
        echo "No ID or Param found";
        return;
    }else{
        handle_ajax_call($ma_id[1]);
    }
}else{
    echo "No API Token found";
    return;
}


function handle_ajax_call($ma_id): void
{   
    $chronik = new Chronik($ma_id);
    $chronik_data = $chronik->get_employee_chronik();

    // Return 
    $output = '<div class="headline">';
        $output .= "<h2>Chronik der Wochenstunden".$ma_id."</h2>";
        $output .= "<span class='close'>&times;</span>";
    $output .= "</div>";
    $output .= "<div class='chronik-content'>";
        $output .= "<div class='content-box-1'>";
        $output .= "<table>";
            $output .= "<thead>";
                $output .= "<tr>";
                    $output .= "<th>Gültig-Ab Datum</th>";
                    $output .= "<th>Wochenstunden</th>";
                    $output .= "<th>Änderung gemacht durch</th>";
                $output .= "</tr>";
            $output .= "</thead>";
            $output .= "<tbody id='chronik-table'>";
                $output .= "<tr>";
                    $output .= "<td>01.01.2021</td>";
                    $output .= "<td>40h</td>";
                    $output .= "<td>Max Mustermann</td>";
                $output .= "</tr>";
            $output .= "</tbody>";
        $output .= "</table>";
    $output .= "</div>";
    $output .= "<div class='content-box-2'>";
        $output .= "<h2>Änderungen</h2>";
        $output .= "<div>";
            $output .= "<table>";
                $output .= "<thead>";
                    $output .= "<tr>";
                        $output .= "<th>Letzte Änderung der Wochenstunden</th>";
                        $output .= "<th>Alter Wert</th>";
                        $output .= "<th>Neuer Wert</th>";
                    $output .= "</tr>";
                $output .= "</thead>";
                $output .= "<tbody id='chronik-changes-table'>";
                    $output .= "<tr>";
                        $output .= "<td>01.01.2021</td>";
                        $output .= "<td>40h</td>";
                        $output .= "<td>38h</td>";
                    $output .= "</tr>";
                $output .= "</tbody>";
            $output .= "</table>";
        $output .= "</div>";
    $output .= "</div>";
    $output .= "</div>";

    echo $output;
}
