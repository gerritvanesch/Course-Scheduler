<?php

define("USERNAME", "******");
define("PASSWORD", "******");
define("LOGINURL", "https://www.uleth.ca/bridge/twbkwbis.P_WWWLogin");
define("LOGINSENDURL", "https://www.uleth.ca/bridge/twbkwbis.P_ValLogin");
define("GETCOURSEURL", "https://www.uleth.ca/bridge/bwskfcls.P_GetCrse");
define("GETCOURSESENDURL", "https://www.uleth.ca/bridge/bwckgens.p_proc_term_date");
define("GETPREURL", "https://www.uleth.ca/bridge/bwckctlg.p_display_courses");
define("TERM", "201703");
define("SUBJECTS", "ADCS&sel_subj=AGBT&sel_subj=AGST&sel_subj=ANTH&sel_subj=ARKY&sel_subj=ART&sel_subj=ARHI&sel_subj=ASIA&sel_subj=ASTR&sel_subj=BCHM&sel_subj=BIOL&sel_subj=BMOL&sel_subj=BSBD&sel_subj=BKFT&sel_subj=CAAP&sel_subj=CHEM&sel_subj=CINE&sel_subj=CPSC&sel_subj=CSPT&sel_subj=DRAM&sel_subj=ESPS&sel_subj=ECON&sel_subj=EDUC&sel_subj=ENGG&sel_subj=ENGL&sel_subj=ENVS&sel_subj=EVBH&sel_subj=EXSC&sel_subj=FA&sel_subj=FNT&sel_subj=FREN&sel_subj=GEOG&sel_subj=HLSC&sel_subj=HPST&sel_subj=HIST&sel_subj=MDST&sel_subj=IDST&sel_subj=JPNS&sel_subj=KNES&sel_subj=LATI&sel_subj=LBED&sel_subj=LBSC&sel_subj=LING&sel_subj=LOGI&sel_subj=MGT&sel_subj=MATH&sel_subj=MSTU&sel_subj=MUSI&sel_subj=MUSE&sel_subj=NAS&sel_subj=NEUR&sel_subj=NMED&sel_subj=NURS&sel_subj=PHIL&sel_subj=PHAC&sel_subj=PHYS&sel_subj=POLI&sel_subj=POSH&sel_subj=PSYC&sel_subj=PUBH&sel_subj=RELS&sel_subj=SOCI&sel_subj=SPAN&sel_subj=STAT&sel_subj=TCSC&sel_subj=TREC&sel_subj=UBRE&sel_subj=WGST&sel_subj=WRIT"); 
define("WANTEDSUBJ", implode("' OR `subj` = '", array("CPSC", "ECON", "PHIL", "LOGI", "MATH")));
define("HIGHESTCRSE", "4999");

$mysqli = new mysqli("localhost", "root", "", "scheduler");

?>