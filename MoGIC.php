<?php

require_once "Grid.php";


class MoGIC{

  private $base_grid;
  private $debug_colors;

  function __construct(){

    $this->base_grid = new Grid(
      $this->get_cols_from_form(),
      $this->get_margin_from_form() * 100 / $this->get_max_width_from_form(),
      $this->get_full_width_from_form(),
      $this->get_full_width_from_form()
    );

    $debug_colors = array(
      "#FFFFCC",
      "#FFCCCC",
      "#FFCCFF",
      "#FFCC99",
      "#CCFFCC",
      "#CCFFFF",
      "#CCFF99",
      "#99FFCC",
      "#CCCC99",
      "#FFFF99",
      "#66CCCC",
      "#FF9999",
      );
  }


  //get-set type functions
  public function get_max_width_from_form(){
    return floatval((isset($_POST['max-width']))?$_POST['max-width']:'1280');
  }

  public function get_min_width_from_form(){
    return floatval((isset($_POST['min-width']))?$_POST['min-width']:'0');
  }

  public function get_device_width_from_form(){
    return (isset($_POST['device-width']))?$_POST['device-width']:'1024';
  }

  public function get_full_width_from_form(){
    return floatval((isset($_POST['full-width']))?$_POST['full-width']:'100');
  }

  public function get_cols_from_form(){
    return floatval((isset($_POST['cols']))?$_POST['cols']:'12');
  }

  public function get_margin_from_form(){
    return floatval((isset($_POST['margin']))?$_POST['margin']:'20');
  }

  public function get_subgrids_from_form(){
    return floatval((isset($_POST['subgrids']))?$_POST['subgrids']:'2');
  }

  public function get_debug_from_form(){
    return intval((isset($_POST['debug']))?$_POST['debug']:'0');
  }

  public function get_center_from_form(){
    return intval((isset($_POST['center']))?$_POST['center']:'1');
  }


  /**
   * function let_rec_get_grid_array calculates, recursively, the full grid.
   *
   * @param Grid $grid the parent grid
   * @param integer $iter the number of iterations. The deep in the recursive function
   * @return Grid 
   **/
  private function let_rec_get_grid_array($grid, $iter){
    if ($iter == 0){
      return array();
    } else {

      $data = array();

      for($i = 1; $i <= $grid->cols; $i++){
        $children_grid = new Grid(
            $i,
            $this->get_margin_from_form() * 100 / $this->get_max_width_from_form(),
            $this->get_full_width_from_form(),
            $grid->get_col_width($i)
          );

        $data[$i] = array(
        'margin' => $grid->margin . '%',
        'width' => $grid->get_col_width($i) . '%',
        'childrens' => $this->let_rec_get_grid_array($children_grid, $iter - 1)
        );
      }
    }

    return $data;
  }

  /**
   * function let_rec_get_full_array returns the full grid asociated to a device width.
   *
   * @return Array 
   **/
  private function let_rec_get_full_array(){

    $device_width = $this->get_device_width_from_form();
    $data = array(
      "$device_width" => $this->let_rec_get_grid_array($this->base_grid, $this->get_subgrids_from_form())
    );

    return $data;
  }


  /**
   * function let_rec_get_css_row prints the grid_array in css.
   *
   * @param Grid $grid_array the children grid
   * @param integer $pre_class the parent's class grid (eg: col_6_1024) to use for childrens (eg: .col_6_1024 .col_4_1024 to paint a col4 inside of a col6)
   * @return String (CSS) 
   **/
  private function let_rec_get_css_row($grid_array, $pre_class = ''){
    $css = '';
    if ($pre_class == ""){
      $css .= '.alpha_' . $this->get_device_width_from_form() . "{margin-left:0 !important;}\n";
      $css .= '.omega_' . $this->get_device_width_from_form() . "{margin-right:0 !important;}\n\n";
    }
    $size = count($grid_array);
    foreach($grid_array as $col => $info){
      $class = $pre_class . '.g_' . $col . '_' . $this->get_device_width_from_form() . " ";
      $css .= $class . "{float:left;margin:0" . (($col != $size)?" " . $info['margin']:"") . ";width:" . $info['width'] . ";}";
      $css .= "\n";
      if (!empty($info['childrens'])) {
        $css .= $this->let_rec_get_css_row($info['childrens'], $class);
        $css .= "\n";
      }
    }
    return $css;
  }


  /**
   * function let_rec_render_css prints the full css for the device. Uses the {@link let_rec_get_css_row} function.
   *
   * @return String 
   **/
  private function let_rec_render_css(){
    $max_width = $this->get_max_width_from_form();
    $min_width = $this->get_min_width_from_form();
    $center = $this->get_center_from_form();

    $css = "body{";
    $css .= (isset($max_width) && !empty($max_width))?"max-width:" . $max_width . "px;":"";
    $css .= (isset($min_width) && !empty($min_width))?"min-width:" . $min_width . "px;":"";
    $css .= (isset($center) && $center == 1)?"margin:0 auto;":"";
    $css .= "}\n\n";

    //Generate container
    $css .= '.container_' . $this->get_cols_from_form() . '_' . $this->get_device_width_from_form() . '{width:' . $this->get_full_width_from_form() . '%;}' . "\n\n";

    $full_array = $this->let_rec_get_full_array();
    $css .= $this->let_rec_get_css_row($full_array[$this->get_device_width_from_form()]);

    return $css;
  }


  /**
   * function let_rec_render_css prints the full css for the device. Uses the {@link let_rec_get_css_row} function.
   *
   * @return String 
   **/
  private function let_print_debug(){
    $css = "";



    return $css;
  }


  /**
   * function get_css returns the css. It's only a controller for CSS and is the public function.
   *  TODO: This functions, maybe, has to recieve the full parameters...
   *
   * @return String 
   **/
  function get_css(){
    return $this->let_rec_render_css();
  }

}