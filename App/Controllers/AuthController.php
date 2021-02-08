<?php

namespace App\Controllers;

use App\Models\User;
use Respect\Validation\Validator as v;
use Zend\Diactoros\Response\RedirectResponse;


class AuthController extends BaseController {

  public function getLogin(){
    return $this->renderHTML('login.twig');
  }

  public function postLogin($request){
    $responseMessage = null;

    if($request->getMethod() == 'POST'){

      $postData = $request->getParsedBody();
      $user = User::where('email', $postData['eMail'])->first();

      if($user){
        if(password_verify($postData['password'], $user->Password)){
          $_SESSION['userId'] = $user->Id;
          return new RedirectResponse('/php-platzi/admin');
        }else{
          $responseMessage = 'Bad Credentials';
        }
      }else{
        $responseMessage = 'Bad Credentials';
      }
    }

    return $this->renderHTML('login.twig',[
      'responseMessage' => $responseMessage
    ]);
  }

  public function getLogout(){
    unset($_SESSION['userId']);
    return new RedirectResponse('/php-platzi/login');
  }
}