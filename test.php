<?php

// Dirty little script hacked together by kelvin for filtering lololol!

//$con = mysqli_connect("localhost", "root", "gizmos", "toilethero");
$con = mysqli_connect("localhost", "root", "root", "toilethero");

if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$distance = $_GET['distance'];	// either 100 or 200 or 300 or anything else
$gender = $_GET['gender'];	// either D or M or F or MF or MFD (no need to provision) or MD or FD
$cleanliness = $_GET['cleanliness'];	// either 1 or anything else
$crowd = $_GET['crowd'];	// either 1 or anything else 

$sql_gender = "\"M\" OR gender = \"F\" OR gender = \"Disabled\"";
$sql_distance = "9999";
$sql_cleanliness = "";
$sql_crowd = "";

if ($gender == "D") {
	$sql_gender = "\"Disabled\"";
} else if ($gender == "M") {
	$sql_gender = "\"M\"";
} else if ($gender == "F") {
	$sql_gender = "\"F\"";
} else if ($gender == "MF") {
	$sql_gender = "\"M\" OR gender = \"F\"";
} else if ($gender == "MD") {
	$sql_gender = "\"M\" OR gender = \"Disabled\"";
} else if ($gender == "FD") {
	$sql_gender = "\"F\" OR gender = \"Disabled\"";
} 

if ($distance == "100") {
	$sql_distance = "100";
} else if ($distance == "200") {
	$sql_distance = "200";
} else if ($distance == "300") {
	$sql_distance = "300";
}

if ($crowd == "1") {
	$sql_crowd = " AND crowd = 1";
}

if ($cleanliness == "1") {
	$sql_cleanliness = " AND cleanliness = 3";
}

$query = "SELECT * FROM toilets_old WHERE (gender = " . $sql_gender . ") AND distance < " . $sql_distance . $sql_cleanliness . $sql_crowd;
$result = mysqli_query($con, $query);

// Declare json array
$json = array();
$i = 0;

// Loop through and make magic
while($row = mysqli_fetch_array($result)) {
	$json[$i]['id'] = $row['id'];
	$json[$i]['gender'] = $row['gender'];
	$json[$i]['building'] = $row['building'];
	$json[$i]['level'] = $row['level'];
	$json[$i]['landmark'] = $row['landmark'];
	$json[$i]['distance'] = $row['distance'];
	$json[$i]['cleanliness'] = $row['cleanliness'];
	$json[$i]['crowd'] = $row['crowd'];
	$json[$i]['url'] = $row['url'];
	$i++;
}

echo json_encode($json);