<?php

require "./config.php";
require_once("WebClient.php");

$wc = new WebClient();

//set initial cookies
$page = $wc->Navigate(LOGINURL);

//login
$post = $wc->getInputs();
$post['sid'] = USERNAME;
$post['PIN'] = PASSWORD;
$page = $wc->Navigate(LOGINSENDURL, $post);

//get course info
$getcourseoptions = "term_in=".TERM."&sel_subj=dummy&sel_day=dummy&sel_schd=dummy&sel_insm=dummy&sel_camp=dummy&sel_levl=dummy&sel_sess=dummy&sel_instr=dummy&sel_ptrm=dummy&sel_attr=dummy&sel_subj=".SUBJECTS."&sel_crse=&sel_title=&sel_insm=%25&sel_from_cred=&sel_to_cred=&sel_camp=M&sel_ptrm=%25&sel_instr=%25&sel_attr=%25&begin_hh=0&begin_mi=0&begin_ap=a&end_hh=0&end_mi=0&end_ap=a";
$page = $wc->Navigate(GETCOURSEURL, $getcourseoptions);

$mysqli->query("DELETE FROM course_info WHERE term = '" . TERM . "'");

//parse
$dom = new DomDocument();
@$dom->loadHtml($page);
$table = $dom->getElementsByTagName("table");
$lines = $table[6]->getElementsByTagName("tr");
$lastcols = null;
foreach ($lines as $line) {
    $cols = $line->getElementsByTagName("td");
    if ($cols->length > 0) {
        if (trim($cols[8]->textContent) != "TBA") {
            $key = $data = preg_replace("/&nbsp;/", " ", htmlentities($cols[2]->textContent . $cols[3]->textContent));
            if (trim($key) != "") {
                $requirements = "";

                $findpre = "?term_in=" . TERM . "&one_subj=" . trim($cols[2]->textContent) . "&sel_crse_strt=" . trim($cols[3]->textContent) . "&sel_crse_end=" . trim($cols[3]->textContent) . "&sel_subj=&sel_levl=&sel_schd=&sel_coll=&sel_divs=&sel_dept=&sel_attr=";
                $pre = $wc->Navigate(GETPREURL . $findpre);

                $pdom = new DomDocument();
                @$pdom->loadHtml($pre);
                $text = $pdom->getElementsByTagName("table")[3]
                    ->getElementsByTagName("tr")[1]
                    ->getElementsByTagName("td")[0]->textContent;

                $text = trim(@explode("Prerequisite(s): ", $text)[1]);
                $text = preg_replace("/\d+\.\d{3} [\s\S]*/", "", $text);

                $requirements = (trim($text) != "") ? "Prerequisite(s): " . trim($text) : "";

                $data = TERM . "', '" . $cols[1]->textContent . "', '" . $cols[2]->textContent . "', '" . $cols[3]->textContent . "', '" . trim($cols[4]->textContent) . "',
                  '" . $cols[7]->textContent . "', '" . $cols[6]->textContent . "', '" . $cols[8]->textContent . "', '" . $cols[9]->textContent . "',
                  '" . $cols[10]->textContent . "', '" . $cols[11]->textContent . "', '" . $cols[12]->textContent . "', '" . $cols[13]->textContent . "', '" . $requirements;
                $data = preg_replace("/&nbsp;/", " ", htmlentities($data));
                $mysqli->query("INSERT INTO course_info (`term`,`crn`,`subj`,`crse`,`sec`,`title`,`cred`,`days`,`time`,`instructor`,`date`,`location`,`attribute`,`requirements`) VALUES
                  ('" . $data . "')");
            } else {
                $res = $mysqli->query("SELECT days FROM course_info WHERE `term`='".TERM."' AND `crn`='".$lastcols[1]->textContent."' LIMIT 1");
                $currentdays = "";
                while($arr = $res->fetch_object()) {
                    $currentdays = $arr->days;
                }
                if (!strpos($currentdays, trim($cols[8]->textContent))) {
                    $mysqli->query("UPDATE course_info SET days='".$currentdays.trim($cols[8]->textContent)."' WHERE `term`='".TERM."' AND `crn`='".$lastcols[1]->textContent."'");
                }
            }
        }
    }
    $lastcols = $cols;
}

header("location: ./");

?>