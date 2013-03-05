<?php 
require_once "MoGIC.php";





$mogic = new MoGIC();

$max_width = $mogic->get_max_width_from_form();
$device_width = $mogic->get_device_width_from_form();
$full_width =  $mogic->get_full_width_from_form();
$cols =  $mogic->get_cols_from_form();
$margin =  $mogic->get_margin_from_form();
$subgrids =  $mogic->get_subgrids_from_form();

$css = $mogic->get_css();

?>
<form action="index.php" method="POST">
  <label for="max-width"> Max width (px): </label><br />
  <input name="max-width" id="max-width" value="<?php print $max_width; ?>" /><br />
  <label for="device-width"> Device width (px): </label><br />
  <input name="device-width" id="device-width" value="<?php print $device_width; ?>" /><br />
  <label for="cols"> # of cols: </label><br />
  <input name="cols" id="cols" value="<?php print $cols; ?>" /><br />
  <label for="full-width">full width (%)</label><br />
  <input name="full-width" id="full-width" value="<?php print $full_width; ?>" /><br />
  <label for="margin">Margin between cols (%)</label><br />
  <input name="margin" id="margin" value="<?php print $margin; ?>" /><br />
  <label for="subgrids">How many subgrids:</label><br />
  <input name="subgrids" id="subgrids" value="<?php print $subgrids; ?>" /><br />

  <label for="css">Css (copy and paste to your file)</label><br />
  <textarea name="css" id="css" rows="30" cols="100" readonly="readonly"><?php print $css; ?></textarea><br />

  <input type="submit" value="Send" />
</form>

