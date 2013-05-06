<?php 
require_once "MoGIC.php";





$mogic = new MoGIC();

$max_width = $mogic->get_max_width_from_form();
$device_width = $mogic->get_device_width_from_form();
$full_width =  $mogic->get_full_width_from_form();
$cols =  $mogic->get_cols_from_form();
$margin =  $mogic->get_margin_from_form();
$subgrids =  $mogic->get_subgrids_from_form();
if ($subgrids < 5){
  $css = $mogic->get_css();
} else {
  print "<b> Five subgrids, even 4, could affect to performance. Two subgrids should be enough for most of grids.</b><br /><br />";
}

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
  <label for="subgrids">How many subgrids (up to 5):</label><br />
  <input name="subgrids" id="subgrids" value="<?php print $subgrids; ?>" /><br />
  <label for="debug">Do you want debug colours?:</label><br />
  <select name="debug" id="debug">
    <option value="0" <?php print (isset($debug) && $debug!=1)?'selected="selected"':''; ?>>NO</option>
    <option value="1" <?php print (isset($debug) && $debug==1)?'selected="selected"':''; ?>>YES</option>
  </select>

    <br />

  <label for="css">Css (copy and paste to your file)</label><br />
  <textarea name="css" id="css" rows="30" cols="100" readonly="readonly"><?php print $css; ?></textarea><br />
  Tama&ntilde;o: <?php print number_format(intval(strlen($css)) / 1024, 2) . " KB"; ?>
  <input type="submit" value="Send" />
</form>

