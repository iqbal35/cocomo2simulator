<! DOCTYPE html>
<html>
<head>
<title>COCOMO II
</title>
<link rel="stylesheet" type="text/css" href="bootstrap.css">

<style>
.error {color: #FF0000;}

ul{
	list-style-type:  none;
	margin: 0;
	padding: 10;
	overflow: hidden;
	background-color: lightgreen;
}
li{
	float: left;
}
li a {
		display: inline-block;
		color: white;
		text-align: center;
		padding: 14px 16px;
		text-decoration: none;
}
li a:hover {
	background-color: #111;

}
.active{
	background-color: red;
}
</style>


</head>
<body style="background-color: lightblue" class="jumbotron">
	<!-- heading -->
	<div class="form-group">
			<h2 align="center"  style=" background-color: grey; padding:50px ;text-decoration:underline;"> COCOMO II - Constructive Cost Model II
			</h2>
		
		<ul>
			<li >Sizing Method 
				<!-- dropdown for selecting sizing method -->
			  	<select name="sizing method" onchange = "location = this.value" >
				<option value="sloc.php" selected>Source Lines Of Code </option>
				<option value="fp.php">Function Points </option>
				</select>
			</li>
			<li><a href = "about.html">About</a></li>
			<li><a href = "help.html">Help</a></li>
		</ul>
	</div>
	
		<!--  php for calculation -->
		<?php
			$size = $cost = "";
			 $size_error =  $cost_error = $E  = ""; 
			 $effort = $schedule = $tcost = 0.0;
			 // checking wheather submit button is clicked or not to move further
			 if(isset($_POST['submit'])){
			 	if(empty($_POST["size"])){
			 		$size_error = "size is required";
				 }
			 	else
			 		$size=$_POST["size"];			// accessing size given by the user

				if(empty($_POST["cost"]))
			 		$cost_error = "this field is required to calculate total cost";
				else
			 		$cost=$_POST["cost"];			//  accessing cost given by the user
			 	//accessing various scale factors choosen by the user
				$prec = fun_prec($_POST["PREC"]);
				$resl = fun_resl($_POST['RESL']);
				$pmat = fun_pmat($_POST['PMAT']);
				$flex = fun_flex($_POST['FLEX']);
				$team = fun_team($_POST['TEAM']);
				// accessing various cost drivers choosen by the user
				$rely = fun_rely($_POST['RELY']);
				$data = fun_data($_POST['DATA']);
				$cplx = fun_cplx($_POST['CPLX']);
				$ruse = fun_ruse($_POST['RUSE']);
				$docu = fun_docu($_POST['DOCU']);
				$pcap = fun_pcap($_POST['PCAP']);
				$acap = fun_acap($_POST['ACAP']);
				$pcon = fun_pcon($_POST['PCON']);
				$apex = fun_apex($_POST['APEX']);
				$plex = fun_plex($_POST['PLEX']);
				$lrex = fun_lrex($_POST['LREX']);
				$time = fun_time($_POST['TIME']);
				$stor = fun_stor($_POST['STOR']);
				$pvol = fun_pvol($_POST['PVOL']);
				$tool = fun_tool($_POST['TOOL']);
				$site = fun_site($_POST['SITE']);
				$sced = fun_sced($_POST['SCED']);

				// calulation of Effort,Schedule,Total Cost using the values found above
				$E = 0.91 + 0.01 * ($prec + $resl + $pmat + $flex + $team);
				
				$effort = 2.94 * pow($size , $E) * ($rely * $data * $cplx * $ruse * $docu * $acap  *  $pcap * $pcon * $apex * $plex * $lrex * $time *   $stor * $pvol * $tool * $site * $sced);
				$EM = 2.94 * pow($size , $E) * ($rely * $data * $cplx * $ruse * $docu * $acap  *  $pcap * $pcon * $apex * $plex * $lrex * $time *   $stor * $pvol * $tool * $site );

				$F = 0.28 + 0.2 * ($E - 0.91);
				$schedule = 3.67 * pow($EM , $F) * $sced;
				$tcost = $cost * $schedule;
			
			}
			
			// defining functions of various scale factors
			function fun_prec($prec){
				if($prec=='vlow')
					$prec = 4.05 ;
				else if($prec=="low")
					$pre = 3.24 ;
				else if($prec=="nom")
					$prec = 2.43 ;
				else if($prec=='high')
					$prec = 1.62 ;
				else if($prec=='vhigh')
					$prec = 0.81 ;
				else if($prec=='ehigh')
					$prec = 0.00 ;
				return $prec;
			}
			function fun_resl($resl){
				if($resl=='vlow')
					$resl = 4.22;
				else if($resl=='low')
					$resl = 3.38;
				else if($resl=='nom')
					$resl = 2.53;
				else if($resl=='high')
					$resl = 1.69;
				else if($resl=='vhigh')
					$resl = 0.84;
				else if($resl=='ehigh')
					$resl = 0.00;
				return $resl;
			}
			function fun_pmat($pmat){
				if($pmat=='vlow')
					$pmat = 4.54;
				else if($pmat=='low')
					$pmat = 3.64;
				else if($pmat=='nom')
					$pmat = 2.73;
				else if($pmat=='high')
					$pmat = 1.82;
				else if($pmat=='vhigh')
					$pmat = 0.91;
				else if($pmat=='ehigh')
					$pmat = 0.00;
				return $pmat;
			}
			function fun_team($team){	
				if($team=='vlow')
					$team = 4.94;
				else if($team=='low')
					$team = 3.95;
				else if($team=='nom')
					$team = 2.97;
				else if($team=='high')
					$team = 1.98;
				else if($team=='vhigh')
					$team = 0.99;
				else if($team=='ehigh')
					$team = 0.00;
				return $team;
			}
			function fun_flex($flex){
				if($flex=='vlow')
					$flex = 6.07;
				else if($flex=='low')
					$flex = 4.86;
				else if($flex=='nom')
					$flex = 3.64;
				else if($flex=='high')
					$flex = 2.43;
				else if($flex=='vhigh')
					$flex = 1.21;
				else if($flex=='ehigh')
					$flex = 0.00;
				return $flex;
			}
			// defing functions of various cost drivers
			function fun_rely($rely){	
				if($rely=='vlow')
					$rely = 0.75;
				else if($rely=='low')
					$rely = 0.88;
				else if($rely=='nom')
					$rely = 1.00;
				else if($rely=='high')
					$rely = 1.15;
				else if($rely=='vhigh')
					$rely = 1.39;
				return $rely;
			}
			function fun_data($data){
				 if($data=='low')
					$data = 0.93;
				else if($data=='nom')
					$data = 1.00;
				else if($data=='high')
					$data = 1.09;
				else if($data=='vhigh')
					$data = 1.19;
				return $data;
			}
			function fun_cplx($cplx){	
				if($cplx=='vlow')
					$cplx = 0.75;
				else if($cplx=='low')
					$cplx = 0.88;
				else if($cplx=='nom')
					$cplx = 1.00;
				else if($cplx=='high')
					$cplx = 1.15;
				else if($cplx=='vhigh')
					$cplx = 1.30;
				else if($cplx=='ehigh')
					$cplx = 1.66;
				return $cplx;
			}
			function fun_ruse($ruse){	
				if($ruse=='low')
					$ruse = 0.91;
				else if($ruse=='nom')
					$ruse = 1.00;
				else if($ruse=='high')
					$ruse = 1.14;
				else if($ruse=='vhigh')
					$ruse = 1.29;
				else if($ruse=='ehigh')
					$ruse = 1.49;
				return $ruse;
			}
			function fun_docu($docu){
				
				if($docu=='vlow')
					$docu = 0.89;
				else if($docu=='low')
					$docu = 0.95;
				else if($docu=='nom')
					$docu = 1.00;
				else if($docu=='high')
					$docu = 1.06;
				else if($docu=='vhigh')
					$docu = 1.13;	
				return $docu;
			}
			function fun_acap($acap){
				
				if($acap=='vlow')
					$acap = 1.50;
				else if($acap=='low')
					$acap = 1.22;
				else if($acap=='nom')
					$acap = 1.00;
				else if($acap=='high')
					$acap = 0.83;
				else if($acap=='vhigh')
					$acap = 0.67;	
				return $acap;
			}
			function fun_pcap($pcap){

				if($pcap=='vlow')
					$pcap = 1.37;
				else if($pcap=='low')
					$pcap = 1.16;
				else if($pcap=='nom')
					$pcap = 1.00;
				else if($pcap=='high')
					$pcap = 0.87;
				else if($pcap=='vhigh')
					$pcap = 0.74;
			
				return $pcap;
			}
			function fun_pcon($pcon){
			
				if($pcon=='vlow')
					$pcon = 1.24;
				else if($pcon=='low')
					$pcon = 1.10;
				else if($pcon=='nom')
					$pcon = 1.00;
				else if($pcon=='high')
					$pcon = 0.92;
				else if($pcon=='vhigh')
					$pcon = 0.84;	
				return $pcon;
			}
			function fun_apex($apex){
				
				if($apex=='vlow')
					$apex = 1.22;
				else if($apex=='low')
					$apex = 1.10;
				else if($apex=='nom')
					$apex = 1.00;
				else if($apex=='high')
					$apex = 0.89;
				else if($apex=='vhigh')
					$apex = 0.81;	
				return $apex;
			}
			function fun_plex($plex){
				if($plex=='vlow')
					$plex = 1.25;
				else if($plex=='low')
					$plex = 1.12;
				else if($plex=='nom')
					$plex = 1.00;
				else if($plex=='high')
					$plex = 0.88;
				else if($plex=='vhigh')
					$plex = 0.81;			
				return $plex;
			}
			function fun_lrex($lrex){
				
				if($lrex=='vlow')
					$lrex = 1.22;
				else if($lrex=='low')
					$lrex = 1.10;
				else if($lrex=='nom')
					$lrex = 1.00;
				else if($lrex=='high')
					$lrex = 0.91;
				else if($lrex=='vhigh')
					$lrex = 0.84;
				
				return $lrex;
			}
			function fun_time($time){	
				if($time=='nom')
					$time = 1.00;
				else if($time=='high')
					$time = 1.11;
				else if($time=='vhigh')
					$time = 1.31;
				else if($time=='ehigh')
					$time = 1.67;
				return $time;
			}
			function fun_stor($stor){	
				if($stor=='nom')
					$stor = 1.00;
				else if($stor=='high')
					$stor = 1.06;
				else if($stor=='vhigh')
					$stor = 1.21;
				else if($stor=='ehigh')
					$stor = 1.57;
				return $stor;
			}
			function fun_pvol($pvol){
				if($pvol=='low')
					$pvol = 0.87;
				else if($pvol=='nom')
					$pvol = 1.00;
				else if($pvol =='high')
					$pvol  = 1.15;
				else if($pvol=='vhigh')
					$pvol = 1.30;
				
				return $pvol;
			}
			function fun_tool($tool){
				if($tool=='vlow')
					$tool = 1.24;
				else if($tool=='low')
					$tool = 1.12;
				else if($tool=='nom')
					$tool = 1.00;
				else if($tool=='high')
					$tool = 0.86;
				else if($tool=='vhigh')
					$tool= 0.72;
				
				return $tool;
			}
			function fun_site($site){
				if($site=='vlow')
					$site = 1.25;
				else if($site=='low')
					$site = 1.10;
				else if($site=='nom')
					$site = 1.00;
				else if($site=='high')
					$site = 0.92;
				else if($site=='vhigh')
					$site = 0.84;
				else if($site=='ehigh')
					$site = 0.78;
				return $site;
			}
			function fun_sced($sced){
				if($sced=='vlow')
					$sced = 1.29;
				else if($sced=='low')
					$sced = 1.10;
				else if($sced=='nom')
					$sced = 1.00;
				else if($sced=='high')
					$sced = 1.00;
				else if($sced=='vhigh')
					$sced = 1.00;
				return $sced;
			}

		?> 
		<!-- end of php code -->
<br>
<br>
<div class="container" align="center">
<h3 align="center"><u> SLOC based calculation</u></h3>
	<!-- HTML form  -->
	<form method="post" action="" class="form-group"><br>
		<p><span class="error">* required field</span></p>
		<strong>Enter SLOC (Source Lines Of Code)</strong>
		<input type="text" name="size" value="<?php echo $size; ?>">
		<span class="error">* <?php echo $size_error; ?></span>
		</br></br>
		<b><u>Please rate the Scale Drivers and Cost Drivers :</u></b><br><br>
		<!-- creating scale drivers table -->
		<strong><u>Software Scale Drivers</u></strong><br><br>
		<table>
			<tr>
				<td>Precedentedness</td>
				<td><select name ="PREC">
						<option value="vlow">Very Low</option>
						<option value="low">Low</option>
						<option value="nom" selected>Nominal</option>
						<option value="high">High</option>
						<option value="vhigh">Very High</option>
						<option value="ehigh">Extra High</option>
					</select>
				</td>
			</tr>

			<tr>
				<td>Development Flexibility</td>
				<td><select name ="FLEX">
						<option value="vlow">Very Low</option>
						<option value="low">Low</option>
						<option value="nom" selected>Nominal</option>
						<option value="high">High</option>
						<option value="vhigh">Very High</option>
						<option value="ehigh">Extra High</option>
					</select>
				</td>
			</tr>

			<tr>
				<td>Architecture/Risk Resolution</td>
				<td><select name="RESL">
						<option value="vlow">Very Low</option>
						<option value="low">Low</option>
						<option value="nom" selected>Nominal</option>
						<option value="high">High</option>
						<option value="vhigh">Very High</option>
						<option value="ehigh">Extra High</option>
					</select><br>
			    </td>
			</tr>
			<tr>
				<td>Team Cohesion</td>
				<td><select name="TEAM">
						<option value="vlow">Very Low</option>
						<option value="low">Low</option>
						<option value="nom" selected>Nominal</option>
						<option value="high">High</option>
						<option value="vhigh">Very High</option>
						<option value="ehigh">Extra High</option>
					</select><br>
				</td>
			</tr>
			<tr>
				<td>Process Maturity</td>
				<td><select name="PMAT">
						<option value="vlow">Very Low</option>
						<option value="low">Low</option>
						<option value="nom" selected>Nominal</option>
						<option value="high">High</option>
						<option value="vhigh">Very High</option>
						<option value="ehigh">Extra High</option>
					</select>
				</td>
			</tr>
		</table><br>
		<!-- creating cost drivers table -->
		<strong><u>Software Cost Drivers</u></strong><br><br>
		<strong> Product </strong><br>
		<table>
			<tr>
				<td>Required Software Reliability</td>
				<td><select name="RELY">
						<option value="vlow">Very Low</option>
						<option value="low">Low</option>
						<option value="nom" selected>Nominal</option>
						<option value="high">High</option>
						<option value="vhigh">Very High</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Data Base Size</td>
				<td><select name="DATA">	
						<option value="low">Low</option>
						<option value="nom" selected>Nominal</option>
						<option value="high">High</option>
						<option value="vhigh">Very High</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Product Complexity</td>
				<td><select name="CPLX">
						<option value="vlow">Very Low</option>
						<option value="low">Low</option>
						<option value="nom" selected>Nominal</option>
						<option value="high">High</option>
						<option value="vhigh">Very High</option>
						<option value="ehigh">Extra High</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Developed for Reusability</td>
				<td><select name="RUSE">
						<option value="low">Low</option>
						<option value="nom" selected>Nominal</option>
						<option value="high">High</option>
						<option value="vhigh">Very High</option>
						<option value="ehigh">Extra High</option>
					</select></td>
			</tr>
			<tr>
				<td>Documentation Match to Lifecycle Needs</td>
				<td><select name="DOCU">
						<option value="vlow">Very Low</option>
						<option value="low">Low</option>
						<option value="nom" selected>Nominal</option>
						<option value="high">High</option>
						<option value="vhigh">Very High</option>
					</select>
				</td>
			</tr>
		</table>

		<strong >Personnel</strong>
		<table>
			<tr>
				<td>Analyst Capability</td>
				<td><select name="ACAP">
						<option value="vlow">Very Low</option>
						<option value="low">Low</option>
						<option value="nom" selected>Nominal</option>
						<option value="high">High</option>
						<option value="vhigh">Very High</option>
					</select>
				</td>
			<tr>
				<td>Programmer Capability</td>
				<td><select name="PCAP">
						<option value="vlow">Very Low</option>
						<option value="low">Low</option>
						<option value="nom" selected>Nominal</option>
						<option value="high">High</option>
						<option value="vhigh">Very High</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Personnel Continuity</td>
				<td><select name="PCON">
						<option value="vlow">Very Low</option>
						<option value="low">Low</option>
						<option value="nom" selected>Nominal</option>
						<option value="high">High</option>
						<option value="vhigh">Very High</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Application Experience</td>
				<td><select name="APEX">
						<option value="vlow">Very Low</option>
						<option value="low">Low</option>
						<option value="nom" selected>Nominal</option>
						<option value="high">High</option>
						<option value="vhigh">Very High</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Platform Experience</td>
				<td><select name="PLEX">
						<option value="vlow">Very Low</option>
						<option value="low">Low</option>
						<option value="nom" selected>Nominal</option>
						<option value="high">High</option>
						<option value="vhigh">Very High</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Language and Toolset Experience</td>
				<td><select name="LREX">
						<option value="vlow">Very Low</option>
						<option value="low">Low</option>
						<option value="nom" selected>Nominal</option>
						<option value="high">High</option>
						<option value="vhigh">Very High</option>
					</select>
				</td>
			</tr>
		</table>
		<strong>Platform</strong><br>
		<table>
			<tr>
				<td>Time Constraint</td>	
				<td><select name="TIME">
						<option value="nom" selected>Nominal</option>
						<option value="high">High</option>
						<option value="vhigh">Very High</option>
						<option value="ehigh">Extra High</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Storage Constraint</td>
				<td><select name="STOR">
						<option value="nom" selected>Nominal</option>
						<option value="high">High</option>
						<option value="vhigh">Very High</option>
						<option value="ehigh">Extra High</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Platform Volatility</td>
				<td><select name="PVOL">
						<option value="low">Low</option>
						<option value="nom" selected>Nominal</option>
						<option value="high">High</option>
						<option value="vhigh">Very High</option>
					</select>
				</td>
			</tr>
		</table>
		<strong>Project</strong><br>
		<table>
			<tr>
				<td>Use of Software Tools</td>
				<td><select name="TOOL">
						<option value="vlow">Very Low</option>
						<option value="low">Low</option>
						<option value="nom" selected>Nominal</option>
						<option value="high">High</option>
						<option value="vhigh">Very High</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Multisite Development</td>
				<td><select name="SITE">
						<option value="vlow">Very Low</option>
						<option value="low">Low</option>
						<option value="nom" selected>Nominal</option>
						<option value="high">High</option>
						<option value="vhigh">Very High</option>
						<option value="ehigh">Extra High</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Required Development Schedule</td>
				<td><select name="SCED">
						<option value="vlow">Very Low</option>
						<option value="low">Low</option>
						<option value="nom" selected>Nominal</option>
						<option value="high">High</option>
						<option value="vhigh">Very High</option>
					</select>
				</td>
			</tr>
		</table><hr>
		<br><br>
		<strong>Software Labour Rates</strong><br>
		Cost per Person-Month (Rupees)
		<input type="text" name="cost"  value="<?php echo $cost; ?>" >
		<span class=error> * <?php echo $cost_error; ?></span>
		<br><br>
		<input type="submit" value="Calculate" name="submit">
	</form>
</div><hr>
<div class="container" align="center">
		<!--  printing results -->
		<strong>Results :</strong><br>
		<!-- php code for printing results -->
		<?php 
			echo "Effort = $effort Person-Months";
			echo '<br>';
			echo "Schedule = $schedule Months";
			echo '<br>';
			echo "Cost = ".$tcost." Rupees";
			echo '<br>';
			echo "Total Equivalent Size = ".$size." SLOC";
		?>
		<!-- end of php code  -->
	</div>
</body>
</html>