<?php

if ($section == "step7") {
	$query_prefs_styleset = sprintf("SELECT prefsStyleSet FROM %s WHERE id='1'",$prefix."preferences");
	$prefs_styleset = mysqli_query($connection,$query_prefs_styleset) or die (mysqli_error($connection));
	$row_prefs_styleset = mysqli_fetch_assoc($prefs_styleset);
	$styleSet = $row_prefs_styleset['prefsStyleSet'];
}

else $styleSet = $_SESSION['prefsStyleSet'];
$query_styles = sprintf("SELECT * FROM %s WHERE (brewStyleVersion='%s' OR brewStyleOwn='custom')",$styles_db_table,$styleSet);

if (($view != "default") && ($section == "styles")) {
		$explodies = explode("-",$view);
		$query_styles .= sprintf(" AND brewStyleGroup='%s' AND brewStyleNum='%s'",$explodies[0],$explodies[1]);
	}

if ((($section == "entry") || ($section == "brew") || ($action == "word") || ($action == "html")) || ((($section == "admin") && ($filter == "judging")) && ($bid != "default"))) $query_styles .= " AND brewStyleActive='Y' ORDER BY brewStyleGroup,brewStyleNum";
elseif (($section == "admin") && ($action == "edit") && ($go != "judging_tables")) $query_styles .= " AND id='$id'";
elseif (($section == "admin") && ($go == "count_by_style")) $query_styles .= " AND brewStyleActive='Y'";
elseif ((($section == "judge") && ($go == "judge")) || ($action == "add") || ($action == "edit")) $query_styles .= " AND brewStyleActive='Y' ORDER BY brewStyleGroup,brewStyleNum";
elseif (($section == "beerxml") && ($msg != "default")) $query_styles .= " AND brewStyleActive='Y' AND brewStyleOwn='bcoe'";
elseif ($section == "sorting") $query_styles .= " AND brewStyleActive='Y'";
elseif ($section == "list") $query_styles .= sprintf(" AND brewStyleGroup = '%s' AND brewStyleNum = '%s'", $row_log['brewCategorySort'], $row_log['brewSubCategory']);
elseif ($section == "styles") {
	if ($filter == "default") $query_styles .= " AND brewStyleActive='Y' ORDER BY brewStyleGroup,brewStyleNum";
	else $query_styles .= " AND brewStyleActive='Y' AND brewStyleGroup='$filter' ORDER BY brewStyleGroup,brewStyleNum";
}

else $query_styles .= "";
$styles = mysqli_query($connection,$query_styles) or die (mysqli_error($connection));
$row_styles = mysqli_fetch_assoc($styles);
$totalRows_styles = mysqli_num_rows($styles);

if ($section != "list") {
	$query_styles2 = sprintf("SELECT * FROM %s WHERE (brewStyleVersion='%s' OR brewStyleOwn='custom')",$styles_db_table,$_SESSION['prefsStyleSet']);
	if (($section == "judge") && ($go == "judge")) $query_styles2 .= " AND brewStyleActive='Y' ORDER BY brewStyleGroup,brewStyleNum";
	elseif ($section == "brew") $query_styles2 .= " AND brewStyleActive='Y' AND brewStyleGroup > '28' AND brewStyleReqSpec = '1'";
	else $query_styles2 .= " AND brewStyleActive='Y' ORDER BY brewStyleGroup,brewStyleNum";
	$styles2 = mysqli_query($connection,$query_styles2) or die (mysqli_error($connection));
	$row_styles2 = mysqli_fetch_assoc($styles2);
	$totalRows_styles2 = mysqli_num_rows($styles2);
}

// echo $query_styles;

?>