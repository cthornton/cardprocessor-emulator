<?php
/**
 *
 * @package CardprocessorEmulator
 */
class CompanyController extends Controller {
  
  public function action_index() {
    $this->requireCompany();
    return array(
      'id' => $this->company->id,
      'username' => $this->company->username
    );
  }
  
  public function action_new() {
    $company = new Company($this->paramsToAttributes('username', 'password', 'name' ));
    $company->save();
    return array('companyId' => $company->id);
  }
  
}