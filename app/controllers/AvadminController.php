<?php

class AvadminController extends WebBase {
  public $_perpage = 20;

  public function initialize() {
    parent::initialize();
    $this->smarty->template_dir = APPPATH.'views/admin';
  }



}
