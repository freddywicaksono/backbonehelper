<?php
include("database.php");
function printCode($source_code)
{

	if (is_array($source_code))
		return false;
  
	$source_code = explode("\n", str_replace(array("\r\n", "\r"), "\n", $source_code));
	$line_count = 1;
    $formatted_code='';
	foreach ($source_code as $code_line)
	{
		$formatted_code .= '<tr><td>'.''.'</td>';
		$line_count++;
	  
		if (preg_match('?(php)?', $code_line))
			$formatted_code .= '<td>'. str_replace(array('<code>', '</code>'), '', highlight_string($code_line, true)).'</td></tr>';
		else
			$formatted_code .= '<td>'.preg_replace('(&lt;\?php&nbsp;)', '', str_replace(array('<code>', '</code>'), '', highlight_string('<?php '.$code_line, true))).'</td></tr>';
	}

	return '<table style="font: 1em Consolas, \'andale mono\', \'monotype.com\', \'lucida console\', monospace;">'.$formatted_code.'</table>';
}

function getPrimaryKey($conn,$tbname){
    $result = $conn->query("DESCRIBE $tbname");

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if (strpos($row["Key"], "PRI") !== false) {
                $val = $row["Field"];
                break;
            }
        }
    } else {
        $val ='';
    }
    return $val;
}

function getUnique($conn,$tbname){
    $result = $conn->query("DESCRIBE $tbname");
    $val="";

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if (strpos($row["Key"], "UNI") !== false) {
                $val = $row["Field"];
            }
        }
    } else {
        $val = "";
    }
    return $val;
}

function getTotalFields($conn, $tbname){
    $result = $conn->query("DESCRIBE $tbname");
    if($result){
        $numrows = $result->num_rows;
    } else {
        $numrows = 0;
    }
    
    return $numrows;
}

function getAllColumnName($conn, $dbname, $tbname){
    $result = $conn->query("SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA='$dbname' AND TABLE_NAME = '$tbname';");
    return $result;
}

function getAllFieldName($conn, $dbname, $tbname){
    $result = $conn->query("SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA='$dbname' AND TABLE_NAME = '$tbname';");
    $list=[];
    while($data=mysqli_fetch_array($result)){
        
        $list[]= $data['COLUMN_NAME'];
        
    }
    return $list;
}
function getEnumValues($conn, $dbname, $tbname, $column){
    $x=array();
    $result = $conn->query("SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS 
    WHERE TABLE_SCHEMA = '$dbname' AND TABLE_NAME = '$tbname' AND COLUMN_NAME = '$column'");
    $data = mysqli_fetch_array($result);
    $val = str_replace("enum","",$data["COLUMN_TYPE"]);
    $val = str_replace("(","",$val);
    $val = str_replace(")","",$val);
    $val = str_replace("'",'',$val);
    $x = explode(",",$val);
    return $x;
}

function ComboEnum($conn, $dbname, $tbname, $column){
    $a = getEnumValues($conn, $dbname, $tbname, $column);
    $x ="";
    $x .="    <select id=\"$column\" name=\"$column\" class=\"form-control show-tick\">\n
                                      <option value=\"<%=$column %>\"><%=$column %></option>\n";
        foreach($a as $b){
            $x .="                                      <option value=\"".$b."\">".$b."</option>\n";
        }
    $x .= '                                    </select>';
    return $x;
}

function ComboEnumEdit($conn, $dbname, $tbname, $column){
    $a = getEnumValues($conn, $dbname, $tbname, $column);
    $x ="";
    $x .="                    <select id=\"$column\" name=\"$column\" class=\"form-control show-tick\" required>\n
                        <option value=\"<?php echo $$column; ?>\"><?php echo $$column; ?></option>\n";
        foreach($a as $b){
            $x .="                        <option value=\"".$b."\">".$b."</option>\n";
        }
    $x .= '                    </select>';
    return $x;
}

function getColumnType($conn, $dbname, $tbname, $column){
    $result = $conn->query("SELECT COLUMN_NAME,DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS 
    WHERE TABLE_SCHEMA = '$dbname' AND TABLE_NAME = '$tbname' AND COLUMN_NAME='$column'");
    $data=mysqli_fetch_array($result);
    $val = $data['DATA_TYPE'];
    return $val;
}

function getSingular($plural) {
    $singular = $plural; // Default to returning the same word if no rules apply
    
    $pluralRules = array(
        '/(s|ss|sh|ch|x|o)$/' => '\1',    // Remove certain endings
        '/ies$/' => 'y',                  // Change 'ies' to 'y'
        '/(us|ss)$/' => '\1',             // Some words remain the same in singular
        '/(octop|vir)i$/' => '\1us',      // Irregular forms like "octopus" to "octopi"
        '/(alias|status)es$/' => '\1',    // Irregular forms like "status" to "statuses"
        '/(vert|ind)ices$/' => '\1ex',    // Irregular forms like "index" to "indices"
        // Add more rules as needed
    );
    
    foreach ($pluralRules as $pattern => $replacement) {
        if (preg_match($pattern, $plural)) {
            $singular = preg_replace($pattern, $replacement, $plural);
            break;
        }
    }
    
    return $singular;
}

function CheckPasswordField($conn, $dbname, $tbname) {
    try {
        $stmt = $conn->prepare("SELECT COLUMN_NAME
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? AND COLUMN_NAME = 'password'");
        if (!$stmt) {
            throw new Exception("Database query error: " . $conn->error);
        }
        $stmt->bind_param("ss", $dbname, $tbname);
        $stmt->execute();
        $stmt->bind_result($field);
        $stmt->fetch();
        $stmt->close();
        
        if ($field === null) {
            $val = false;
        } else {
            $val = true;
        }
        return $val;
    } catch (Exception $e) {
        // Handle the exception, log it, or return an appropriate error message.
        return false;
    }
}
function insertMenu($conn,$name,$url){
    $iconArray = [
        "add_location",
        "layers",
        "near_me",
        "place",
        "my_location",
        "local_cafe",
        "local_play",
        "apps",
        "ac_unit",
        "business_center",
        "beach_access",
        "cake",
        "pages",
        "whatshot",
        "star",
        "assignment",
        "theaters"
    ];
    
    // Get a random key/index from the array
    $randomKey = array_rand($iconArray);
    
    // Use the random key to access the corresponding element
    $randomIcon = $iconArray[$randomKey];

    $result = $conn->query("insert into menu(name,url,icon)values('$name','$url','$randomIcon')");
    $id = $conn->insert_id;
    return $id;
}

?>