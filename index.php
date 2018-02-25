<a href="./populate.php">Populate Database</a>
<a href="./visibility.php">Change Course Selection</a>
<br>
<br>
<?php

    require "./config.php";

    function array_slice_assoc($array, $keys) {
        return array_intersect_key($array,array_flip($keys));
    }

    $res = $mysqli->query("SELECT * FROM course_info WHERE `term` = '".TERM."' AND visible=1 ORDER BY id ASC");

    $courses = array(
        'M' => array(),
        'W' => array(),
        'F' => array(),
        'T' => array(),
        'R' => array(),
    );

    $info = "<table id='info-table'>";
    $info .= "<tr><th>CRN</th><th>Course</th><th>Title</th><th>Instructor</th><th>Credits</th><th>Location</th><th>Attribute</th></tr>";
    $prev_subj = "";
    $prev_crse = "";
    while ($obj = $res->fetch_object()) {
        if ($prev_subj != "" && $prev_subj != $obj->subj) {
            $info .= "<tr style='border-top: 2px solid black;'>";
        } else {
            $info .= "<tr>";
        }
        $info .= "<td>".$obj->crn."</td><td>".$obj->subj." ".$obj->crse." ".$obj->sec."</td><td>".$obj->title."</td><td>".preg_replace("/ \(P\)/","",$obj->instructor)."</td><td>".$obj->cred."</td><td>".$obj->location."</td><td>".$obj->attribute."</td></tr>";
        $prev_subj = $obj->subj;

        $days = str_split($obj->days);
        foreach ($days as $day) {
            $courses[$day][] = $obj;
        }
    }
    $info .= "</table>";


    echo "<div style='position:relative; height: 575px;'>";
    foreach ($courses as $k => $day) {
        $num_day = array(
            'M' => array(),
            'W' => array(),
            'F' => array(),
            'T' => array(),
            'R' => array(),
        );
        foreach ($day as $course) {
            $times = explode("-", $course->time);
            foreach ($times as &$time) {
                $time = explode(" ", $time);
                $t = explode(":", $time[0]);
                if ($time[1] == 'pm' && $t[0] != 12) {
                    $t[0] += 12;
                }
                $time = (($t[0]*3600 + $t[1]*60)/100)-252;
            }
            for ($i = $times[0]; $i <= $times[1]; $i=$i+3) {
                $num_day[$k][$i] = (isset($num_day[$k][$i]) ? $num_day[$k][$i]+1 : 1);
            }
        }
        $num_columns = max($num_day[$k]);
        $num_filled = array();
        foreach ($day as $course) {
            $times = explode("-", $course->time);
            foreach ($times as &$time) {
                $time = explode(" ", $time);
                $t = explode(":", $time[0]);
                if ($time[1] == 'pm' && $t[0] != 12) {
                    $t[0] += 12;
                }
                $time = (($t[0]*3600 + $t[1]*60)/100)-252;
            }
            $keys = array();
            for ($i = $times[0]; $i <= $times[1]; $i=$i+3) {
                $keys[] = $i;
                $num_filled[$i] = (isset($num_filled[$i]) ? $num_filled[$i]+1 : 1);
            }
            $this_num = max(array_slice_assoc($num_filled, $keys))-1;
            $height = $times[1]-$times[0];
            $offset = 300 / $num_columns;
            $left = 0;
            switch ($k) {
                case 'M': $left = 100; break;
                case 'W': $left = 400; break;
                case 'F': $left = 700; break;
                case 'T': $left = 1100; break;
                case 'R': $left = 1400; break;
            }
            $left += ($this_num*$offset);
            echo "<div style='margin-top: ".($times[0]+1)."px; height: ".($height-2)."px; line-height: ".($height-2)."px; margin-left: ".($left+1)."px; position: absolute; font-size: 10px; background: #EEF7FA; width: ".($offset-2)."px; border: 1px solid #666;text-align:center;'>".$course->subj." ".$course->crse." ".$course->sec."</div>";
        }
    }
    for ($i = 0; $i <= 540; $i=$i+9) {
        if ($i % 36 == 0) {
            $time = (($i+252)*100)/3600;
            $time = explode(".", $time);
            $time = $time[0] . ":00";
            echo "<div style='border-top: 1px solid black; font-size: 10px; width: 100px; text-align: center; margin-top: ".($i+1)."px; position:absolute;'>$time</div>";
            echo "<div style='border-top: 1px solid black; font-size: 10px; width: 100px; text-align: center; margin-top: ".($i+1)."px; margin-left: 1000px; position:absolute;'>$time</div>";
            echo "<hr style='border: none; border-top: 1px solid black; width: 1700px; margin-top: ".($i+1)."px; position: absolute; z-index: -99'>";
        } else {
            echo "<hr style='border: none; border-top: 1px solid #eee; width: 1700px; margin-top: ".($i+1)."px; position: absolute; z-index: -99'>";
        }
    }

    echo "<div style='width:0;height:538px;position:absolute;border:1px solid black;margin-top:1px;margin-left:100px;'>&nbsp;</div>";
    echo "<div style='width:0;height:538px;position:absolute;border:1px solid black;margin-top:1px;margin-left:400px;'>&nbsp;</div>";
    echo "<div style='width:0;height:538px;position:absolute;border:1px solid black;margin-top:1px;margin-left:700px;'>&nbsp;</div>";
    echo "<div style='width:0;height:538px;position:absolute;border:1px solid black;margin-top:1px;margin-left:1000px;'>&nbsp;</div>";
    echo "<div style='width:0;height:538px;position:absolute;border:1px solid black;margin-top:1px;margin-left:1100px;'>&nbsp;</div>";
    echo "<div style='width:0;height:538px;position:absolute;border:1px solid black;margin-top:1px;margin-left:1400px;'>&nbsp;</div>";
    echo "<div style='width:298px;height:35px;line-height:35px;font-size:14px;position:absolute;background:#E6BBAD;margin-top:1px;border:1px solid black;text-align:center;margin-left:101px;'>Monday</div>";
    echo "<div style='width:298px;height:35px;line-height:35px;font-size:14px;position:absolute;background:#E6BBAD;margin-top:1px;border:1px solid black;text-align:center;margin-left:401px;'>Wednesday</div>";
    echo "<div style='width:298px;height:35px;line-height:35px;font-size:14px;position:absolute;background:#E6BBAD;margin-top:1px;border:1px solid black;text-align:center;margin-left:701px;'>Friday</div>";
    echo "<div style='width:298px;height:35px;line-height:35px;font-size:14px;position:absolute;background:#E6BBAD;margin-top:1px;border:1px solid black;text-align:center;margin-left:1101px;'>Tuesday</div>";
    echo "<div style='width:298px;height:35px;line-height:35px;font-size:14px;position:absolute;background:#E6BBAD;margin-top:1px;border:1px solid black;text-align:center;margin-left:1401px;'>Thursday</div>";

    echo "</div>";


    echo $info;

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

    tr td:last-child {
        border-right: none;
    }
</style>
