
<?php
$htmlContent = file_get_contents("https://provo.mid.as/signage.pl?screen=5");
$DOM = new DOMDocument();
$DOM->loadHTML($htmlContent);

$Header = $DOM->getElementsByTagName('th');
$Detail = $DOM->getElementsByTagName('td');

//# Get header name of the table
$aDataTableHeaderHTML = [];
foreach ($Header as $NodeHeader) {
    $aDataTableHeaderHTML[] = trim($NodeHeader->textContent);
}
// print_r($aDataTableHeaderHTML); die();

//# Get row data/detail table without header name as key
$aDataTableDetailHTML = [];
$rowData = [];
foreach ($Detail as $sNodeDetail) {
    $rowData[] = trim($sNodeDetail->textContent);
    if (count($rowData) === count($aDataTableHeaderHTML)) {
        $aDataTableDetailHTML[] = $rowData;
        $rowData = [];
    }
}
// print_r($aDataTableDetailHTML); die();

//# Get row data/detail table with header name as key and outer array index as row number
$aDataTableDetailHTML = array_map(function ($row) use ($aDataTableHeaderHTML) {
    return array_combine($aDataTableHeaderHTML, $row);
}, $aDataTableDetailHTML);
// print_r($aDataTableDetailHTML); die();
// print_r($aDataTableDetailHTML);
?>

<h1>Today's Meeting Room Schedule</h1>
	<?php
		$countEvents = count($aDataTableDetailHTML);
		$eventCounter = 0;
		if($countEvents == 0) {
			echo('<h2>There Are No Events Today</h2>');
		} else {
				while( $eventCounter < $countEvents) {
				?>
					<h2>&#9632; <?php echo $aDataTableDetailHTML[$eventCounter]['Meeting']; ?></h2>
					<div class="meetingTime">
						<h3>Time</h3>
						<?php echo $aDataTableDetailHTML[$eventCounter]['Times']; ?>
					</div>
					<div class="meetingRoom">
						<h3>Room</h3>
						<?php echo $aDataTableDetailHTML[$eventCounter]['Room']; ?>
					</div>
				<?php
				$eventCounter++;
			}
		}
	?>
