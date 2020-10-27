<div class="w-75 right">
	<table>
		<tr>
			<td>Nome</td>
			<td>Baixar</td>
		</tr>
		<?php
			$types = array('csv');
			if ( $handle = opendir('csv/') ) {
			    while ( $entry = readdir( $handle ) ) {
			        $ext = strtolower( pathinfo( $entry, PATHINFO_EXTENSION) );
			        if(in_array($ext,$types)){
			        	echo "<tr>";
				        	echo"<td>".$entry."</td>";
				        	echo "<td><a href='csv/".$entry."'>Baixar</a></td>";
			        	echo"</tr>";
			        }
			    }
			    closedir($handle);
			}    
		?>	
	</table>
</div>
