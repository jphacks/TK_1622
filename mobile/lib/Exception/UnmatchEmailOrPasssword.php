<?php

namespace jigenji\Exception;


class UnmatchEmailOrPasssword extends \Exception {
  protected $message = 'User Name/Password do not match!';
}
