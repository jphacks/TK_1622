<?php
// publicのindex.phpに対するController

namespace jigenji\Controller;

class Index extends \jigenji\Controller {

  public function run() {
    if (!$this->isLoggedIn()) {
      // login
      header('Location: ' . SITE_URL . '/login.php');
      exit;
    }

    // get users info
    

  }

}
