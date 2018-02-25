<button onclick="clearall()">Clear All</button>

<?php

    require "./config.php";

    if (!$_POST) {
        $res = $mysqli->query("SELECT * FROM course_info WHERE `term` = '" . TERM . "' AND crse <='" . HIGHESTCRSE . "' AND sec REGEXP '^[A-Za-z]+$' ORDER BY id ASC");

        echo "<form action='./visibility.php' method='post'>";
        echo "<table>";
        $prev_subj = "";
        $prev_crse = "";
        while ($obj = $res->fetch_object()) {
            if ($prev_subj != "" && $prev_subj != $obj->subj) {
                echo "<tr style='border-top: 2px solid black;'>";
            } else {
                echo "<tr>";
            }
            echo "<td><input type='checkbox' name='" . $obj->subj . '-' . $obj->crse . "' " . (($obj->visible==1) ? "checked='checked'" : "") ."></td>";
            echo "<td>" . $obj->subj . " " . $obj->crse . " " . $obj->sec . "</td><td>" . $obj->title . " (" . preg_replace("/ \(P\)/", "", $obj->instructor) . ")</td><td>" . $obj->crn . "</td><td style='font-size:12px;max-width:1000px;'>" . $obj->requirements . "</td></tr>";
            $prev_subj = $obj->subj;
        }
        echo "</table>";
        echo "<button type='submit'>Submit</button></form>";
    } else {
        $mysqli->query("UPDATE course_info SET visible=0");
        foreach ($_POST as $post => $v) {
            $post = explode("-", $post);
            $mysqli->query("UPDATE course_info SET visible=1 WHERE subj='".$post[0]."' AND crse='".$post[1]."'");
        }
        header("location:./");
    }

?>

<style>
    table {
        border-collapse: collapse;
    }

    tr:nth-child(odd) {
        background: #EEE;
    }

    td {
        padding: 2px;
        border-right: 2px solid black;
    }

    td:last-child {
        border-right: none;
    }
</style>

<script src="./jquery-3.1.1.min.js"></script>
<script>
    function clearall() {
        $("input").removeAttr("checked");
    }

    function checkall() {
        $("input").attr("checked", "checked");
    }
</script>