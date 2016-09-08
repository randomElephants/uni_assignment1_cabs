<h2>1.Click button below to search for all unassigned booking requests with a pick-up time within 2 hours</h2>
	
	<form method="post" action="admin?list-all">
		<p>
			<input type="submit" value="List all"/>
		</p>
	</form>
	
	<?php 
		if (isset($result)) {
			$result->printResultsTable();
		}
	?>
	
	<h2>Input a reference number below and click "update" button to assign a taxi to that request</h2>
	
	<form method="post" action="admin?update">
		<p>
			<label for="refNumber">Reference number:</label>
			<input type="text" id="refNumber" name="refNumber"/>
			<input type="submit" value="update"/>
		</p>
	</form>
	
	<?php 
		if (isset($updateResult) && isset($refNumber)) {
			echo "<p>The booking request $refNumber has been properly assigned.";
			$updateResult->printResultsTable();
		}
	?>