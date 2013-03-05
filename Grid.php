<?php

class Grid{

  //Number of cols
  public $cols;
  
  //Full Width. By this way I don't know any use for this variable.
  public $full_width;

  //Relative with from parent. 
  public $relative_width_from;

  //Margin. Maybe if is a second level grid, the value is not like the father's margin.
  public $margin;

  //Extra margin. First and last column hasn't got margin. It has to be added and divided by number of cols.
  public $extra_margin;

  //Extra margin. First and last column hasn't got margin. It has to be added and divided by number of cols.
  public $single_col_width;


  /**
   * Constructor
   **/
  public function __construct($cols = 12, $margin_from_parent = 0.5, $full_width = 100, $relative_width_from = 100){
    $this->cols = $cols;
    $this->full_width = $full_width;
    $this->relative_width_from = $relative_width_from;
    $this->margin = $this->calculate_margin($margin_from_parent);
    $this->extra_margin = $this->calculate_extra_margin();
    $this->single_col_width = $this->calculate_single_col_width();
  }


  /**
   * Calculate extra margin.
   **/
  private function calculate_extra_margin(){
    return $this->margin * 2 / $this->cols;
  }


  /**
   * Calculate the margin. Useful if margin, by default, is -1.
   **/
  private function calculate_margin($margin_from_parent){
    return ($margin_from_parent * $this->full_width) / $this->relative_width_from;
  }


  /**
   * returns the width of one column
   **/
  private function calculate_single_col_width(){
    return ($this->full_width / $this->cols) - ($this->margin * 2) + $this->extra_margin;
  }


  /**
   * Returns the margin
   **/
  public function get_margin(){
    return $this->margin;
  }

  
  /**
   * Returns the width of the col
   * = colWidth * #Col + ( Margin * 2 * ( #Col - 1 ))
   **/
  public function get_col_width($col){
    return $this->single_col_width * $col + ($this->margin * 2 * ($col - 1));
  }



}