<?php

require_once "Grid.php";


class MoGIC{

  private $base_grid;

  function __construct(){

    $this->base_grid = new Grid(
      $this->get_cols_from_form(),
      $this->get_margin_from_form(),
      $this->get_full_width_from_form(),
      $this->get_full_width_from_form()
    );

  }


  //get-set type functions
  public function get_max_width_from_form(){
    return floatval((isset($_POST['max-width']))?$_POST['max-width']:'1280');
  }

  public function get_device_width_from_form(){
    return floatval((isset($_POST['device-width']))?$_POST['device-width']:'1024');
  }

  public function get_full_width_from_form(){
    return floatval((isset($_POST['full-width']))?$_POST['full-width']:'100');
  }

  public function get_cols_from_form(){
    return floatval((isset($_POST['cols']))?$_POST['cols']:'12');
  }

  public function get_margin_from_form(){
    return floatval((isset($_POST['margin']))?$_POST['margin']:'0.5');
  }

  public function get_subgrids_from_form(){
    return floatval((isset($_POST['subgrids']))?$_POST['subgrids']:'2');
  }


  private function let_rec_get_grid_array($grid, $iter){
    if ($iter == 0){
      return array();
    } else {

      $data = array();

      for($i = 1; $i <= $grid->cols; $i++){
        $children_grid = new Grid(
            $i,
            $this->get_margin_from_form(),
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



  private function let_rec_get_full_array(){

    $device_width = $this->get_device_width_from_form();
    $data = array(
      "$device_width" => $this->let_rec_get_grid_array($this->base_grid, $this->get_subgrids_from_form())
    );

    return $data;
  }


  private function let_rec_get_css_row($grid_array, $pre_class = ''){
    $css = '';

    foreach($grid_array as $col => $info){
      $class = $pre_class . '.col_' . $col . '_' . $this->get_device_width_from_form() . " ";
      $css .= $class . "{float:left; margin: 0 " . $info['margin'] . "; width:" . $info['width'] . ";}";
      $css .= "\n";
      if (!empty($info['childrens'])) {
        $css .= $this->let_rec_get_css_row($info['childrens'], $class);
      }
    }

    return $css;
  }

  private function let_rec_render_css(){
    $css = "body{max-width:" . $this->get_max_width_from_form() . "px}" . "\n\n";

    //Generate container
    $css .= '.container_' . $this->get_cols_from_form() . '_' . $this->get_device_width_from_form() . '{width:' . $this->get_full_width_from_form() . '%;}' . "\n\n";

    $full_array = $this->let_rec_get_full_array();
    $css .= $this->let_rec_get_css_row($full_array[$this->get_device_width_from_form()]);

    return $css;
  }


  function get_css(){
    return $this->let_rec_render_css();
  }

}