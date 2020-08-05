<p style="font-size:10px">
<html>
<br>
<br>
<img src="cam1.jpg?v=<?php echo Date("Y.m.d.G.i.s")?>" width="640" height="480"/>
<br>
<br>
<p style="font-size:20px">
<?php
echo "<br>";
echo $_SERVER['SERVER_ADDR'];
echo "/";
echo gethostname();
echo "<br>";

if(isset($_GET['iso'])) 
	{
		echo "ISO:",$_GET['iso'];
		$iso1 = $_GET['iso'];
	}
else 
	{
		$iso1 = "500";
	}



if(isset($_GET['FPS']))
	{
		echo "&nbsp;&nbsp;&nbsp;&nbsp;FPS:",$_GET['FPS'];
		$FPS1 = $_GET['FPS'];
	}
else
	{
		$FPS1 = "30";
	}


if(isset($_GET['SS']))
	{
		echo "&nbsp;&nbsp;&nbsp;&nbsp;ShutterSpeed:",  $_GET['SS'];
		$SS1 = $_GET['SS'];
	}
else
	{
		$SS1 = "22000";
	}

if(isset($_GET['EV']))
        {
                echo "&nbsp;&nbsp;&nbsp;&nbsp;EV:",  $_GET['EV'];
                $EV1 = $_GET['EV'];
        }
else
        {
                $EV1 = "0";
        }


if(isset($_GET['H']))
	{
		echo "&nbsp;&nbsp;&nbsp;&nbsp;HEIGHT:",  $_GET['H'];
		$H1 = $_GET['H'];
	}
else
	{
		$H1 = "1080";
	}


if(isset($_GET['W']))
	{
		echo "&nbsp;&nbsp;&nbsp;&nbsp;WIDTH:",  $_GET['W'];
		$W1 = $_GET['W'];
	}
else
	{
		$W1 = "1920";
	}


if(isset($_GET['WB']))
        {
                echo "&nbsp;&nbsp;&nbsp;&nbsp;WB:",  $_GET['WB'];
                $WB = $_GET['WB'];
        }
else
        {
                $WB = "auto";
        }



?>
<br>

<form action="index.php" method="get">

ISO:<input type="text" name="iso" size="4" value="<?php echo $iso1; ?>">
&nbsp;&nbsp;
FPS:<input type="text" name="FPS" size="3" value="<?php echo $FPS1; ?>">
&nbsp;&nbsp;
SHUTTERSPEED:  <input type="text" size="5" name="SS"  value="<?php echo $SS1; ?>">
&nbsp;&nbsp;
EV:<input type="text" name="EV" size="3" value="<?php echo $EV1; ?>">
&nbsp;&nbsp;
HEIGHT:<input type="text" size="5" name="H"  value="<?php echo $H1; ?>">
&nbsp;&nbsp;
WIDTH:<input type="text" size="5" name="W"  value="<?php echo $W1; ?>">
&nbsp;&nbsp;
<label for="cars">AWB:</label>
<select name="WB" id="WB">
        <option value="<?php echo $WB; ?>"><?php echo $WB; ?></option>
	<option value="auto">auto</option>
	<option value="sun">sun</option>
	<option value="cloud">cloud</option>
	<option value="shade">shade</option>
	<option value="tungsten">tungsten</option>
	<option value="fluorescent">fluorescent</option>
	<option value="incandescent">incandescent</option>
	<option value="flash">flash</option>
	<option value="horizon">horizon</option>
</select>
&nbsp;&nbsp;
<input type="submit" class="update" value="UpDate" />

</form>



</body>
</html>
<html>
<body>
</body>
</html>

<?php
$iso=$_GET["iso"];
$FPS=$_GET["FPS"];
$SS=$_GET["SS"];
$H=$_GET["H"];
$W=$_GET["W"];
$ip=$_SERVER['SERVER_ADDR'];
$WB=$_GET["WB"];
$EV=$_GET["EV"];
//echo $WB;

error_reporting(E_ALL);

function launch() {
			global $iso, $FPS, $SS, $ip, $H, $W, $WB, $EV;
			shell_exec('pkill raspivid');
			shell_exec('raspivid -awb "'.$WB.'" -ev "'.$EV.'" -ss  "'.$SS.'"  --ISO  "'.$iso.'" -drc high  -t 0 -h  "'.$H.'" -w  "'.$W.'" -fps  "'.$FPS.'"  -b 4500000 -o - | gst-launch-1.0 -v fdsrc ! h264parse ! rtph264pay config-interval=1 pt=96 ! gdppay ! tcpserversink host= "'.$ip.'" port=5000  > /dev/null &');
			
		}

function preview() {
			global $iso, $FPS, $SS, $ip;
			shell_exec('pkill raspivid');
			shell_exec('sudo raspistill --ISO "'.$iso.'"  -ss "'.$SS.'"  -o cam1.jpg');
		}

function kill() {
			shell_exec('pkill raspivid');
		}

?>

<head>
    <title>
        WebGstream!
    </title>
</head>

<body style="text-align:center;">

    <?php
        if(array_key_exists('button1', $_POST)) { 
		button1();
		launch();
        }

        if(array_key_exists('button2', $_POST)) {
		button2();
		kill();
        }
        if(array_key_exists('button3', $_POST)) {
		button3();
 		preview();
        }

        function button1() {
            echo "Gstreamer Launched.";
        }

        function button2() {
            echo "Gstreamer Has Stopped.";
        }

	function button3() {
	    echo "Preview";
	}
    ?>

    <form method="post">
        <input type="submit" name="button1"
                class="button" value="Launch"  />
        <input type="submit" name="button2"
                class="button" value="Kill" />
        <input type="submit" name="button3"
                class="button" value="Preview" />

    </form>
</head>
</html>
