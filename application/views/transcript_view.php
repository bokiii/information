<?php 
	tcpdf();  
	
	// create new PDF document
	$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

	// set document information
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('Lala Melody Abordo');
	$pdf->SetTitle('Official Transcript of Records');
	$pdf->SetSubject('Transcript');
	$pdf->SetKeywords('transcript');

	// remove default header/footer
	$pdf->setPrintHeader(false);
	//$pdf->setPrintFooter(false);

	// set default monospaced font
	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

	// set margins
	$pdf->SetMargins(5, 12, 8);
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

	// set auto page breaks
	$pdf->SetAutoPageBreak(true, 17);

	// set image scale factor
	//$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

	// ---------------------------------------------------------

	// set font
	//$pdf->SetFont('times', 'BI', 12);
	$pdf->SetFont('times');

	// add a page
	$pdf->AddPage();
	ob_start();
?>		
	
	
<?php 
	if(isset($file_name) && $file_name != NULL) {
		$image_name = $file_name;
	} else {
		$image_name = "blank.png";
	}
?>	
	
	<style type="text/css">

		table.grade_head th {
			font-size: 10px;
			border: 1px solid #000;
			text-align: center;
			font-weight: bold;
		}
		
		table.grade {
			border: 1px solid #000;
		}
		
		table.grade td {
			text-align: center;
			font-size: 12px;
			border-right: 1px solid #000;
		}
		
		
	</style>
	
	<table id="header" cellspacing="10">
		<tr>
			<td width="150" align="right"><img src="images/wvsu_logo.jpg" alt="WVSU Logo" /></td>
			<td width="228" align="center" >
				Republic of the Philippines <br /> 
				<strong>WEST VISAYAS STATE UNIVERSITY</strong><br /> 
				<strong>JANIUAY CAMPUS</strong>  <br />  
				Formerly Janiuay Polytechnic College <br />
				Janiuay, Iloilo <br />  <br />
				<strong>OFFICIAL TRANSCRIPT OF RECORDS</strong>
			</td>
		
			
			<td width="158" align="right"><img src="profiles/<?php echo $file_name; ?>" alt="Profile Pic" /></td>
		</tr>
		
	</table>
	<br /><br />
	<table id="details" cellspacing="12">
		<tr> 
			<td width="75" align="left">Name:</td>
			<td style="border-bottom: 1px solid #000;" width="180" align="left"><?php printf("%s, %s %s.", $last_name, $first_name, substr($middle_name, 0, 1)); ?></td>
			<td width="72" align="left">Date:</td>
			<td style="border-bottom: 1px solid #000;" width="175" align="left"><?php echo date("F j, Y"); ?></td>
		</tr>
		<tr>
			<td align="left">Home Address:</td>
			<td style="border-bottom: 1px solid #000;"><?php printf("%s", $address); ?></td>
			<td align="left">Date of Birth:</td>
			<td style="border-bottom: 1px solid #000;"><?php printf("%s", $birth_date); ?></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td align="left">Place of Birth: </td>
			<td style="border-bottom: 1px solid #000;"><?php printf("%s", $place_of_birth); ?></td>
		</tr>
		<tr>
			<td align="left">Curriculum:</td>
			<td style="border-bottom: 1px solid #000;"><?php printf("%s", $course); ?></td>
			<td align="left">Entrance Data:</td>
			<td style="border-bottom: 1px solid #000;"><?php printf("%s", $entrance_data); ?></td>
		</tr>
	</table>
	<br /><br />
	<table  class="grade_head" cellpadding="5">
		<tr>
			<th width="100">TERM</th>	
			<th width="72">COURSE NO.</th>
			<th width="235">DESCRIPTIVE TITLE</th>
			<th width="50">FINAL</th>
			<th width="55">COMP.</th>
			<th width="55">CREDIT</th>
		</tr>
	</table>  

	<table class="grade" cellpadding="5">
	<?php echo $subjects; ?>  
	</table>
	
	<p align="center">================================  End of Transcript ===============================</p>
	
	<table id="rating_system" cellpadding="3">
		<tr>
			<td width="100" rowspan="4">Rating System: </td>
			<td width="467">1.00 (97-100) Excellent, 1.25 (93-96), Highly Outstanding, 1.50 (89-92) Outstanding</td>
		</tr>
		<tr>
			<td>1.75 (87-88) Very Good, 2.00(85-86) Good, 2.25 (83-84) Very Satisfactory</td>
		</tr>
		<tr>
			<td>2.50 (80-82) Satisfactory, 2.75 (77-79) Fair, 3.00 (75-76) Passing, 5.00 (Less than 75) Failure</td>
		</tr>
		<tr>
			<td>INC - Incomplete Grade note completed within one year will automatically become "5.0"</td>
		</tr>
	</table>   
	
	<br /><br />
	
	<table id="remarks" cellpadding="3"> 
		<tr>   
			<td width="100">Remarks:</td>
			<td width="467" style="border-bottom: 1px solid #000;"><?php printf("%s", $remarks); ?></td>
		</tr>
	</table>
	
	<br /> <br /> <br /> <br />
	
	<table align="center" id="signatures"> 
		<tr>
			<td>LALA MELODY A. ABORDO</td>
			<td>SONY P. VELONERO</td>
		</tr>
		<tr>
			<td>Prepared by</td>
			<td>Registrar III</td>
		</tr>  
	</table>

	
<?php 
	$content = ob_get_contents();
	ob_end_clean();
	$pdf->writeHTML($content, true, false, true, false, '');

	$pdf->lastPage();
	
	$pdf->Output('transcript.pdf', 'I');
?>
	
	
	
	
	
	
	
	
	
	
	