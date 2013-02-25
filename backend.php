<?php

function player_error()
{


echo "As you can see, there was an error. <br />
I would suggest going back and checking your spelling<br />

";
die();
}
$cName = ucfirst($_POST["cName"]);
$rName = ucfirst($_POST["rName"]);

$url = 'http://us.battle.net/api/wow/character/'. $rName .'/'. $cName .'?fields=items';
$file_headers = @get_headers($url);
if($file_headers[0] == 'HTTP/1.1 404 Not Found') {
    $exists = false;
	set_error_handler('player_error');
}
else {
    $exists = true;
}
$contents = file_get_contents($url);
$json = json_decode( $contents );
//useless values

$name = $json->name;
$level = $json->level;
$realm = $json->realm;
$battlegroup =$json->battlegroup;
$class =$json->class;
$avgItem = $json->items->averageItemLevelEquipped;

//char gear
$head = $json->items->head->tooltipParams;
$shoulder = $json->items->shoulder->tooltipParams;
$cape = $json->items->back->tooltipParams;
$chest = $json->items->chest->tooltipParams;
$bracer = $json->items->wrist->tooltipParams;
$hands = $json->items->hands->tooltipParams;
$legs = $json->items->legs->tooltipParams;
$boots = $json->items->feet->tooltipParams;
$mainHand = $json->items->mainHand->tooltipParams;
 
//used to check if there is an offhand
//it checks the icon for the mainHand


$count = (int)0;//keeps track of unenchanted items
$check = "false"; //is(stays*) flase if more than 3 unenchanted items



if(strpos($mainIcon, '1h')){
$offHand = $json->items->offHand->tooltipParams;
$items = array($head, $shoulder, $cape, $chest, $bracer, $hands, $hands, $legs, $boots, $mainHand, $offHand);
//array, below loop goes through each item and checks if it is enchanted

foreach($items as $value){
checkEnchant($value);
}//end foreach
}//end if 

else {

$items = array($head, $shoulder, $cape, $chest, $bracer, $hands, $hands, $legs, $boots, $mainHand);
//array, below loop goes through each item and checks if it is enchanted


foreach($items as $value){
checkEnchant($value);
}//end foreach


}//end else



//main function to check if item is enchanted
function checkEnchant($item){
 	global $count;//ref to global var
 	global $check;//see above
 	$decode = json_encode($item);//turns json code passed to function to a php array
if(strpos($decode, 'enchant')) {
	//echecks for pattern "enchant" in toolTipParams, which are "extras" 
	//on the item, include reforge, gems and enchant
    $check = "true";//if so, $check is set to true
}//end if
else {
	//if the item($check is false) is unenchanted
	$check = "false";//sets $check to false
		++$count;
		//increases var $count by one if item is unenchanted
			if($count >= 3)
				//checks if $count is greater than or equal to 3, if statement falls through
			{
				die('you have at least 3 unenchanted items');
			}//end 2nd if

}//end else
return $check;
//iif no more than 3 items are unenchanted, $check returns as true
}//end function


//switch statment to check which class the person is
switch($class) {
case 1:
	$class = "Warrior";
	break;
case 2:
	$class = "Paladin";
	break;
case 3:
	$calss = "Hunter";
	break;
case 4:
	$class = "Rogue";
	break;
case 5:
	$class = "Priest";
	break;
case 6:
	$class = "Death Knight";
	break;
case 7:
	$class = "Shaman";
	break;
case 8:
	$class = "Mage";
	break;
case 9:
	$class = "Warlock";
	break;

case 10:
	$class = "wut";
	//there is no 10 class???
	//*does alien guy hands* pandas
	break;

case 11:
	$class = "Druid";
	break;
}

?>

<!--html-->
<!DOCTYPE html>
<html>
<head>
	<title>result</title>
</head>

<body>


<!DOCTYPE HTML>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Art Taylor | identity video</title>
        <link rel="stylesheet" href="../css/random.css" /><!-- Styles for my specific scrolling content -->
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script>

</script>


    </head>
    <body>
    	<div class ="wrapper">
<?php include("../includes/nav.php"); ?>
	<div class ="box contactList paraBox">
<table>
	<tr>
		<td>Name: </td><td><?php echo $name ?></td>
	</tr>
	<tr>
		<td>Level:</td><td><?php echo $level ?></td>
	</tr>

	<tr>
		<td>Battlegroup</td><td><?php echo $battlegroup ?></td>
	</tr>
	<tr>
		<td>class</td><td><?php echo $class ?></td>
	</tr>
	</tr>
	<tr>
		<td>item level</td><td><?php echo $avgItem ?></td>
	</tr>
	<tr>
		<td>Do they have enchants?</td><td><?php echo $check ?></td>
	</tr>
</table>

<a href = "../pages/undermine.php" alt = "back">back</a>

	
</div><!--what does this end?-->
</div>

<div class="clearfooter">
	<!--clear footer creaters a space for a "real" footer on the bottom of it-->
</div><!--ends clearfooter-->
</div>



<div class = "positionRel footer wrapper">
<?php include("../includes/footer.php"); ?>
</div>
<!--start scripts-->
	
	<script src="../javascript/jquery.ui.widget.js" type="text/javascript"></script><!-- jQuery UI widget factory -->
	<script src="../javascript/jquery.smoothDivScroll-1.1-min.js" type="text/javascript"></script><!-- Smooth Div Scroll 1.1 - minified for faster loading-->
	
	<script src="../javascript/video.js" type="text/javascript"></script>
		<script type="text/javascript">
		// Initialize the plugin with no custom options
		$(window).load(function() {
			$("div#makeMeScrollable").smoothDivScroll({});
		});
	</script>
	<!--end scripts-->


</body>
</html>