<div id="content">
	<form action="<?php echo site_url(); ?>" method="post" id="delete_form">
		<table>
			<tr>
				<th><input type="checkbox" value="#" class="main_check"  /></th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Middle Name</th>
				<th>Address</th>
			</tr>
			<tr>
				<td><input type="checkbox" value="#" class="sub_check"  /></td>
				<td>Mark</td>
				<td>Boribor</td>
				<td>Babon</td>
				<td>Janiuay, Iloilo</td>
			</tr>
			<tr>
				<td><input type="checkbox" value="#" class="sub_check"  /></td>
				<td>Junar</td>
				<td>Gato</td>
				<td>Poblacion</td>
				<td>Janiuay, Iloilo</td>
			</tr>
			<tr>
				<td><input type="checkbox" value="#" class="sub_check"  /></td>
				<td>Judie</td>
				<td>Predonio</td>
				<td>Samentar</td>
				<td>Janiuay, Iloilo</td>
			</tr>
		</table>
		<div id="actions">
			<button id="add_button">Add</button>
			<button id="delete_button">Delete</button>
		</div>
	</form>
</div>