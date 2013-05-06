<?php 
require_once "MoGIC.php";





$mogic = new MoGIC();

$max_width = $mogic->get_max_width_from_form();
$min_width = $mogic->get_min_width_from_form();
$device_width = $mogic->get_device_width_from_form();
$full_width =  $mogic->get_full_width_from_form();
$cols =  $mogic->get_cols_from_form();
$margin =  $mogic->get_margin_from_form();
$subgrids =  $mogic->get_subgrids_from_form();
$debug =  $mogic->get_debug_from_form();
$center =  $mogic->get_center_from_form();

if ($subgrids <= 5){
  $css = $mogic->get_css();
} else {
  print "<b> Five subgrids, even 4, could affect to performance. Two subgrids should be enough for most of grids.</b><br /><br />";
}
?>
<form action="index.php" method="POST">
  <div class="col1">
    <div class="form-item">
      <label for="max-width"> Body max-width (0 for none): </label>
      <input name="max-width" id="max-width" value="<?php print $max_width; ?>" />
      <span class="units">px</span>
    </div>
    <div class="form-item">
    <label for="min-width"> Body min-width (0 for none): </label>
    <input name="min-width" id="min-width" value="<?php print $min_width; ?>" />
      <span class="units">px</span>
    </div>
    <div class="form-item">
    <label for="center">Center:</label>
    <select name="center" id="center">
      <option value="0" <?php print (isset($center) && $center!=1)?'selected="selected"':''; ?>>NO</option>
      <option value="1" <?php print (isset($center) && $center==1)?'selected="selected"':''; ?>>YES</option>
    </select>
    </div>
    <div class="form-item">
    <label for="device-width"> Device (can be 1024 for <em>g_x_1024</em>, mobile for <em>g_x_mobile</em>, m for <em>g_x_m</em>, ...): </label>
    <input name="device-width" id="device-width" value="<?php print $device_width; ?>" />
    </div>
    <div class="form-item">
    <label for="cols"> # of cols: </label>
    <input name="cols" id="cols" value="<?php print $cols; ?>" />
    </div>
    <div class="form-item">
    <label for="full-width">Full width:</label>
    <input name="full-width" id="full-width" value="<?php print $full_width; ?>" />
      <span class="units">%</span>
    </div>
    <div class="form-item">
    <label for="margin">Full margin between cols:</label>
    <input name="margin" id="margin" value="<?php print $margin; ?>" />
      <span class="units">px</span>
    </div>
    <div class="form-item">
    <label for="subgrids">How many subgrids (up to 5):</label>
    <input name="subgrids" id="subgrids" value="<?php print $subgrids; ?>" />
    </div>
    <div class="form-item">
    <label for="debug">Do you want debug colours?:</label>
    <select name="debug" id="debug">
      <option value="0" <?php print (isset($debug) && $debug!=1)?'selected="selected"':''; ?>>NO</option>
      <option value="1" <?php print (isset($debug) && $debug==1)?'selected="selected"':''; ?>>YES</option>
    </select>
    </div>
    <div class="form-item">
    <input type="submit" value="Send" class="submit"/>
    </div>
  </div>
  <div class="col2">
    <div class="form-text-area">
    <label for="css">Css (<?php print number_format(intval(strlen($css)) / 1024, 2) . " KB"; ?>):</label><br />
    <textarea name="css" id="css" rows="30" cols="100" readonly="readonly"><?php print $css; ?></textarea>
    </div>
  </div>
</form>

