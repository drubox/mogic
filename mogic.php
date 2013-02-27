<?php

class MoGIC{

  function __constructor(){

  }
  //get-set type functions
  function get_max_width_from_form(){
    return floatval((isset($_POST['max-width']))?$_POST['max-width']:'1280');
  }

  function get_device_width_from_form(){
    return floatval((isset($_POST['device-width']))?$_POST['device-width']:'1024');
  }

  function get_full_width_from_form(){
    return floatval((isset($_POST['full-width']))?$_POST['full-width']:'100');
  }

  function get_cols_from_form(){
    return floatval((isset($_POST['cols']))?$_POST['cols']:'12');
  }

  function get_margin_from_form(){
    return floatval((isset($_POST['margin']))?$_POST['margin']:'0.5');
  }

  //functions to calculate grid
  function get_extra_width($number_of_cols, $margin){
    //There are two margins (first and second) that cannot be counted.
    $extra_width = ($margin * 2) / $number_of_cols; 

    return $extra_width;
  }

  function get_one_col_width(){
    //=(ancho/(Columnas)) - (Margen*2)
    $col_width = ($this->get_full_width_from_form() / $this->get_cols_from_form()) - ($this->get_margin_from_form() * 2);

    return $col_width;
  }

  function get_col_width($col){
          // = colWidth * #Col + ( Margin * 2 * ( #Col - 1 )) + (ExtraWidth * #Col)
    $one_col_width = $this->get_one_col_width();
    $cols_width = $one_col_width * $col + ($this->get_margin_from_form()*2*($col-1)) + ($this->get_extra_width(
      $this->get_cols_from_form(),
      $this->get_margin_from_form()) * $col);
    return $cols_width;
  }

  function get_width_array(){
    $device_width = $this->get_device_width_from_form();
    $data = array(
      "$device_width" => array()
    );

    for($i = 1; $i <= $this->get_cols_from_form(); $i++ ){
      $data["$device_width"][$i] = array(
        'width' => $this->get_col_width($i) . '%'
        );
    }



    return $data;
  }


  function generate_array(){
    $data = array(
      //0.5% of margin
      '1024' => array(
        1 => array(
          'width' => '11.625%',
          'childrens' => array(
            1 => array(
              'width' => '100%'
            )
          )
        ),
        2 => array(
          'width' => '24.25%',
          'childrens' => array(
            1 => array(
              'width' => '49.5%'
            ),
            2 => array(
              'width' => '100%'
            )
          )
        )
      )
    );
  }




  function render_css(){
    $css = "body{max-width:" . $this->get_max_width_from_form() . "px}" . "\n\n";

    //Generate container
    $css .= '.container_' . $this->get_cols_from_form() . '_' . $this->get_device_width_from_form() . '{width:' . $this->get_full_width_from_form() . '%;}' . "\n\n";

    for($i = $this->get_cols_from_form(); $i >= 1; $i--){
      $css .= '.col_' . $i . '_' . $this->get_device_width_from_form();
      if ($i != 1){
        $css .= ",\n";
      } else {
        $css .= "{float:left; margin:0 " . $this->get_margin_from_form() . "%;}";
        $css .= "\n\n";
      }
    }


    //Generate col_styles
    $widths = $this->get_width_array();

    foreach ($widths as $grid){

      foreach ($grid as $col => $width){
        $css .= '.col_' . $col . '_' . $this->get_device_width_from_form();
        $css .= "{width:" . $width['width'] . ";}";
        $css .= "\n";
      }
    }
    
    return $css;
  }

  function get_css(){
    return $this->render_css();
  }

}