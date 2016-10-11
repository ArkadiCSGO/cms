<?php if ($server1["success"] > 0 ) : ?>
	<table class="table table-striped">
    <thead>
      <tr>
        <th>Skins</th>
        <th>Pseudo</th>
        <th>Grade IG</th>
        <th>Monnaie IG</th>
      </tr>
    </thead>
	<?php 
  foreach ($server1_membre["success"]  as $value) :
    $groupe = $connexion_1->call("permissions.getGroups", array("$value"));
    $groupe = $groupe["success"]["0"];
    $nbr_money_server = $connexion_1->call("econ.getBalance", array("$value"));
    $money = number_format($nbr_money_server["success"], 0, '.', ' '); 
  ?>
  <tbody>
    <tr>
      <td><center> <a href="../membre/<?php echo $value ; ?>"><img src="https://cravatar.eu/helmhead/<?php echo $value ; ?>/45.png" title="<?php echo $value; ?>" rel="tooltip" data-toggle="tooltip" data-placement="top"></A></center></td>
      <td><a href="../membre/<?php echo $value ; ?>"><?php echo $value ;?></a></td>
      <td><?php echo $groupe ;?></td>
      <td><?php echo $money ;?></td>
    </tr>
  </tbody>		
  <?php endforeach; ?>
</table>
<?php else : ?>
	  <div class="alert alert-danger"> Il n'y a aucun connecté</div>
<?php endif; ?>