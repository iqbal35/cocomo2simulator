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
	<div>
		<h2 align="center"  style=" background-color: grey; padding:50px ;text-decoration:underline;"> COCOMO II - Constructive Cost Model II
		</h2>
	</div>
	<ul>
		<li >Sizing Method
			<!-- drop down for selecting sizing method --> 
		  	<select name="sizing method" onchange = "location = this.value" >
			<option value="fp.php">Function Points </option>
			<option value="sloc.php" >Source Lines Of Code </option>
			</select>
		</li>
		<li><a href = "about.html">About</a></li>
		<li><a href = "help.html">Help</a></li>
	</ul>
	
	<!--  php code  for calculations -->
	<?php

	//	$cost  = $cost_error = $wilf = $welf = $weip = $weop = $weeq = "" ;
			
			$cost_error = "";
		$effort = $schedule = $tcost = $fp = $lang = $size = 0;




		if(isset($_POST['submit'])){					//checking submit button clicked or not
			if(empty($_POST['cost']))
				$cost_error = "this field is required to calculate total cost";
			else
				$cost=$_POST['cost'];					// accessing the cost given by the user
			// accessing the weight given by the user to different Function Types
			$wilf = $_POST['ilf'];
			$welf = $_POST['elf'];
			$weip = $_POST['eip'];
			$weop = $_POST['eop'];
			$weeq = $_POST['eeq'];

			//checking the weighting factor and assigning values accordingly
		
			if($_POST['cilf'] == 'simple')
				$cilf = 7;
			if($_POST['cilf'] == "average")
				$cilf =10 ;
			if($_POST['cilf'] == 'complex')
				$cilf = 15 ;
			if($_POST['celf'] == 'simple')
				$celf = 5;

			if($_POST['celf'] == 'average')
				$celf = 7 ;

			if($_POST['celf'] == 'complex')
				$celf = 10;
			if($_POST['ceip'] == 'simple')
				$ceip = 3;

			if($_POST['ceip'] == 'average')
				$ceip = 4;

			if($_POST['ceip'] == 'complex')
				$ceip = 6;
			if($_POST['ceop'] == 'simple')
				$ceop = 4;

			if($_POST['ceop'] == 'average')
				$ceop = 5;

			if($_POST['ceop'] == 'complex')
				$ceop = 7;
			if($_POST['ceeq'] == 'simple')
				$ceeq = 3;

			if($_POST['ceeq'] == 'average')
				$ceeq = 4;

			if($_POST['ceeq'] == 'complex')
				$ceeq = 6;
			
			// accessing the weight given to complexity analysis factor of FP 
			$rad1 = $_POST['rad1'];
			$rad2 = $_POST['rad2'];
			$rad3 = $_POST['rad3'];
			$rad4 = $_POST['rad4'];
			$rad5 = $_POST['rad5'];
			$rad6 = $_POST['rad6'];
			$rad7 = $_POST['rad7'];
			$rad8 = $_POST['rad8'];
			$rad9 = $_POST['rad9'];
			$rad10 = $_POST['rad10'];
			$rad11 = $_POST['rad11'];
			$rad12 = $_POST['rad12'];
			$rad13 = $_POST['rad13'];
			$rad14 = $_POST['rad14'];

			$lang = fun_lang($_POST['lang']);      // accessing the language factor language choosen by the user and assign value accordingly
			// accessing the scaling factors choosen by the user
			$prec = fun_prec($_POST["PREC"]);
			$resl = fun_resl($_POST['RESL']);
			$pmat = fun_pmat($_POST['PMAT']);
			$flex = fun_flex($_POST['FLEX']);
			$team = fun_team($_POST['TEAM']);
			// accessing the cost drivers choosen by the user
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


			// calculations of FP,Effort,Schedule,Total Cost 
			$ufp = $wilf * $cilf + $welf * $celf + $weip * $ceip + $weop * $ceop + $weeq * $ceeq ;
				$di = $rad1 + $rad2 + $rad3 + $rad4 + $rad5 + $rad6 + $rad7 + $rad8 + $rad9 + $rad10 + $rad11 + $rad12 + $rad13 +  $rad14 ;
			$caf = 0.65 + 0.01 * $di ;
			$fp = $caf * $ufp ;
			$size = $fp * $lang ;

			
			$E = 0.91 + 0.01 * ($prec + $resl + $pmat + $flex + $team);
			$effort = 2.94 * pow($size , $E) * ($rely * $data * $cplx * $ruse * $docu * $acap  *  $pcap * $pcon * $apex * $plex * $lrex * $time *   $stor * $pvol * $tool * $site * $sced);
			$EM = 2.94 * pow($size , $E) * ($rely * $data * $cplx * $ruse * $docu * $acap  *  $pcap * $pcon * $apex * $plex * $lrex * $time *   $stor * $pvol * $tool * $site );

			$F = 0.28 + 0.2 * ($E - 0.91);
			$schedule = 3.67 * pow($EM , $F) * $sced;
			$tcost = $cost * $schedule;

		}
		// function definition of the language choosen by the user
		function fun_lang($lang){
			if($lang == 'c')
				$l = 128;
			else if($lang == 'cpp')
				$l = 53 ;
			else if($lang == 'java')
				$l = 53;
			else if($lang == 'ada')
				$l = 71;
			else if($lang == 'assembly')
				$l = 320;
			else if($lang == 'basic')
				$l = 64;
			else if($lang == 'html')
				$l = 15;
			else if($lang == 'pascal')
				$l = 91;
			else if($lang == 'perl')
				$l = 27;
			else if($lang == 'spreadsheet')
				$l = 6;
			else if($lang == 'oracle')
				$l = 40;
			return $l;
		}
		// function definitions of different scaling factors
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
				$team = 1.38;
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
		//function definitions of different cost drivers
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



	?>  <!-- end of php code -->
	<div class="container" align="center">
		<div class=form-group>
			<h3 align="center"> <u>FP based calculation</u></h3>
			<br>
			<br>
			<p><span class="error">* required field</span></p>
		</div>
			<!--  HTML form    -->
		<div class="form-group">
			<form method = "post" action = "">  
					<b><u>Please assign the weightage to each Function Types :</u></b><br><br>
					<!--  function type table   -->
					<table>
						<tr>
							<td><b>S.No.</b></td>
							<td><b>Function Types</b></td>
							<td><b>Weight</b></td>
							<td><b>Complexity</b></td>  
						</tr>
						<tr>
							<td>1.</td>
							<td title="refers to how many files that the software you plan to develop will have to develop">Internal Logic Files</td>
							<td><input type=text name='ilf' value="<?php if(isset($_POST['submit'])){ echo $wilf; }?>" ></td>
							<td>
								<select name = "cilf">
									<option value = "simple">Simple</option>
									<option value = "average" selected>Average</option>
									<option value = "complex">Complex</option>
								</select>
								</td>
						</tr>
						<tr>
							<td>2.</td>
							<td title="refers to how many other systems or software that your software will have to interface with ">External Logic Files</td>
							<td><input type=text name='elf' value="<?php if(isset($_POST['submit'])){ echo $welf; } ?>"></td>
							<td>
								<select name = "celf">
									<option value = 'simple'>Simple</option>
									<option value ='average' selected>Average</option>
									<option value = 'complex'>Complex</option>
								</select>
							</td>

						
						</tr>
						<tr>
							<td>3.</td>
							<td title="refers to how many input fields of data will have to fill in">External Input</td>
							<td><input type=text name='eip' value="<?php if(isset($_POST['submit'])){ echo $weip; } ?>"></td>
							<td>
								<select name = 'ceip'>
									<option value = 'simple'>Simple</option>
									<option value = 'average' selected>Average</option>
									<option value = 'complex'>Complex</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>4.</td>
							<td title="refers to how many outputs will be generated to se">External Output</td>
							<td><input type=text name='eop' value="<?php if(isset($_POST['submit'])){ echo $weop; }?>"></td>
							<td>
								<select name = 'ceop'>
									<option value = 'simple'>Simple</option>
									<option value = 'average' selected>Average</option>
									<option value = 'complex'>Complex</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>5.</td>
							<td title="refers to how many times the user has to interact with the program without entering any data in">External Enquiry</td>
							<td><input type=text name = 'eeq' value="<?php if(isset($_POST['submit'])){ echo $weeq ; }?>"></td>
							<td>
								<select name = 'ceeq'>
									<option value = 'simple'>Simple</option>
									<option value = 'average' selected>Average</option>
									<option value = 'complex'>Complex</option>
								</select>
							</td>
						</tr>
					</table>
		</div>
		<div class="form-group">
			<br><br><hr>
			<b><u>Please answer to the following questions :</u></b><br>
			Assign a value of importance to each question . The range is from 0 to 5 .Zero being of low importance to five being of high importance.
			<br><br><br>
			<!-- function point analysis complexity table  -->
			<table>
				<tr>
					<td><b>S.No.</b></td>
					<td><b>Function Point Analysis Complexity</b></td>
					<td><b>1 </b></td>
					<td><b>2</b></td>
					<td><b>3 </b></td>
					<td><b>4</b></td>
					<td><b>5</b></td>
				</tr>
				
				<tr>
					<td> 1.    </td>
					<td>  Does the system require reliable backup and recovery?   </td>
					<td><input type=radio name="rad1" value="1"></td>
					<td><input type=radio name="rad1" value="2"></td>
					<td><input type=radio name="rad1" value="3"></td>
					<td><input type=radio name="rad1" value="4" checked></td>
					<td><input type=radio name="rad1" value="5"></td>
					
				</tr>
				<tr>
					<td>  2.   </td>
					<td>  Are data communications required?  </td>
					<td><input type=radio name="rad2" value="1"></td>
					<td><input type=radio name="rad2" value="2"></td>
					<td><input type=radio name="rad2" value="3"></td>
					<td><input type=radio name="rad2" value="4" checked></td>
					<td><input type=radio name="rad2" value="5"></td>
					
				</tr>
					<tr>
					<td>  3.   </td>
					<td>  Are there distributed processing functions?  </td>
					<td><input type=radio name="rad3" value="1"></td>
					<td><input type=radio name="rad3" value="2"></td>
					<td><input type=radio name="rad3" value="3"></td>
					<td><input type=radio name="rad3" value="4" checked></td>
					<td><input type=radio name="rad3" value="5"></td>
					
				</tr>
					<tr>
						<td>  4.   </td>
						<td>   Is performance critical?  </td>
						<td><input type=radio name="rad4" value="1"></td>
						<td><input type=radio name="rad4" value="2"></td>
						<td><input type=radio name="rad4" value="3"></td>
						<td><input type=radio name="rad4" value="4" checked></td>
						<td><input type=radio name="rad4" value="5"></td>
					
					</tr>
					<tr>
						<td>  5.   </td>
						<td>  Will the system run in an existing, heavily utilized operational environment?   </td>
						<td><input type=radio name="rad5" value="1">
						<td><input type=radio name="rad5" value="2"></td>
						<td><input type=radio name="rad5" value="3"></td>
						<td><input type=radio name="rad5" value="4" checked></td>
						<td><input type=radio name="rad5" value="5"></td>
					</tr>
					<tr>
						<td>   6.  </td>
						<td>   Does the system require on-line data entry?  </td>
						<td><input type=radio name="rad6" value="1"></td>
						<td><input type=radio name="rad6" value="2"></td>
						<td><input type=radio name="rad6" value="3"></td>
						<td><input type=radio name="rad6" value="4" checked></td>
						<td><input type=radio name="rad6" value="5"></td>
					
					</tr>
					<tr>
						<td>  7.   </td>
						<td>   Does the on-line data entry require the input transaction to be built over multiple screens or operations?  </td>
						<td><input type=radio name="rad7" value="1"></td>
						<td><input type=radio name="rad7" value="2"></td>
						<td><input type=radio name="rad7" value="3"></td>
						<td><input type=radio name="rad7" value="4" checked></td>
						<td><input type=radio name="rad7" value="5"></td>
					
					</tr>
					<tr>
						<td> 8.    </td>
						<td>  Are the master files updated on-line?   </td>
						<td><input type=radio name="rad8" value="1"></td>
						<td><input type=radio name="rad8" value="2"></td>
						<td><input type=radio name="rad8" value="3"></td>
						<td><input type=radio name="rad8" value="4" checked></td>
						<td><input type=radio name="rad8" value="5"></td>
				
					</tr>
					<tr>
						<td> 9.    </td>
						<td>  Are the inputs, outputs, files, or inquiries complex?   </td>
						<td><input type=radio name="rad9" value="1"></td>
						<td><input type=radio name="rad9" value="2"></td>
						<td><input type=radio name="rad9" value="3"></td>
						<td><input type=radio name="rad9" value="4" checked></td>
						<td><input type=radio name="rad9" value="5"></td>
						
				</tr>
					<tr>
						<td> 10.    </td>
						<td> Is the internal processing complex?    </td>
						<td><input type=radio name="rad10" value="1"></td>
						<td><input type=radio name="rad10" value="2"></td>
						<td><input type=radio name="rad10" value="3"></td>
						<td><input type=radio name="rad10" value="4" checked></td>
						<td><input type=radio name="rad10" value="5"></td>
					
					</tr>
					<tr>
						<td>  11.   </td>
						<td>  Is the code designed to be reusable?   </td>
						<td><input type=radio name="rad11" value="1"></td>
						<td><input type=radio name="rad11" value="2"></td>
						<td><input type=radio name="rad11" value="3"></td>
						<td><input type=radio name="rad11" value="4" checked></td>
						<td><input type=radio name="rad11" value="5"></td>
						
					</tr>
					<tr>
						<td> 12.    </td>
						<td>  Are conversion and installation included in the design?   </td>
						<td><input type=radio name="rad12" value="1"></td>
						<td><input type=radio name="rad12" value="2"></td>
						<td><input type=radio name="rad12" value="3"></td>
						<td><input type=radio name="rad12" value="4" checked></td>
						<td><input type=radio name="rad12" value="5"></td>
						
					</tr>
					<tr>
						<td>  13.   </td>
						<td>  Is the system designed for multiple installations in different organizations?   </td>
						<td><input type=radio name="rad13" value="1"></td>
						<td><input type=radio name="rad13" value="2"></td>
						<td><input type=radio name="rad13" value="3"></td>
						<td><input type=radio name="rad13" value="4" checked></td>
						<td><input type=radio name="rad13" value="5"></td>
					
					</tr>
					<tr>
						<td>  14.   </td>
						<td>   Is the application designed to facilitate change and ease of use by the user?  </td>
						<td><input type=radio name="rad14" value="1"></td>
						<td><input type=radio name="rad14" value="2"></td>
						<td><input type=radio name="rad14" value="3"></td>
						<td><input type=radio name="rad14" value="4" checked></td>
						<td><input type=radio name="rad14" value="5"></td>
					
					</tr>
			</table>
		</div>
			<br><br><hr>
		<div class="form-group">
			<b><u>Please rate the Scale Drivers and Cost Drivers :</u></b><br><br>
			<strong><u>Software Scale Drivers</u></strong><br><br>
	<!-- scaling factors table  -->
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

	<strong><u>Software Cost Drivers</u></strong><br><br>
	<strong> Product </strong><br>
	<!--  cost drivers table  -->
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
				</select>
			</td>
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
		</tr><br>
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
	</table>
	<div>
	<br><br>
	<div class="form-group">

		<strong>Software Labour Rates</strong><br>
		Cost per Person-Month (Rupees)
		<input type="text" name="cost"  value="<?php if(isset($_POST['submit'])){ echo $cost ; } ?>" >
		<span class=error> * <?php echo $cost_error; ?></span>
		<br>
		Language
		<!-- drop down box for selecting language -->
		<select name = "lang">
			<option value = "c" >C</option>
			<option value = "cpp" selected >C++</option>
			<option value = "ada" >Ada</option>
			<option value = "assembly" >Assembly</option>
			<option value = "Basic" >basic</option>
			<option value = "java" >Java</option>
			<option value = "html" >HTML 3.0</option>
			<option value = "pascal" >Pascal</option>
			<option value = "perl" >PERL</option>
			<option value = "spreadsheet" >Spreadsheet</option>
			<option value = "oracle" >Oracle</option>
		</select><br><br><br>

		<input type="submit" value="Calculate" name="submit">
	<div>	

	</form>
</div>
	<hr>
		<!--  displaying results -->
		<strong>Results :</strong><br>
		<!--  php code for showing result -->
		<?php 
			echo "Total Equivalent Size = ".$size." SLOC";
			echo '<br>';
			echo "Function Point = ".$fp." FP";
			echo '<br>';
			echo "Effort = $effort Person-Months";
			echo '<br>';
			echo "Schedule = $schedule Months";
			echo '<br>';
			echo "Cost = ".$tcost." Rupees";
				
		?>  <!-- end of php code -->
	</form>
	<br><br>

</body>
</html>