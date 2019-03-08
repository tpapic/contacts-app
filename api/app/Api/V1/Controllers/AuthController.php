<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tymon\JWTAuth\JWTAuth;
use App\Api\V1\Requests\RegistrationRequest;
use App\Api\V1\Requests\SocialLoginRequest;
use App\User;
use App\Util\SocialNetworks\Local;
use App\Util\SocialNetworks\Github;
use App\Util\SocialNetworks\Google;
use Auth;

class AuthController extends Controller {

  public function registration(Request $request, JWTAuth $JWTAuth)
  {
        $socialId = $request->input('social_provider_id');

        switch($socialId) {
          case '1':
            $network = new Local(1);
          break;
          case '2':
            $network = new Facebook(2);
          break;
          case '3':
            $network = new Google(3);
          break;

          default:
            return ['success' => false, 'reason' => 'Wrong social network'];
        }

        return $network->registration($request, $JWTAuth);
    }

  public function login(Request $request, JWTAuth $JWTAuth)
  {
        $socialId = $request->input('social_provider_id');

        switch($socialId) {
          case '1':
            $network = new Local(1);
          break;
          case '2':
            $network = new Facebook(2);
          break;
          case '3':
            $network = new Google(3);
          break;

          default:
            return ['success' => false, 'reason' => 'Wrong social network'];
        }

        return $network->login($request, $JWTAuth);
    }

  public function logout(Request $request, JWTAuth $JWTAuth)
  {
      $user = auth()->user();

      if(!$user) {
        return ['success' => false, 'reason' => 'Wrong token'];
      }

      $socialId = $user->social_provider_id;

      switch($socialId) {
        case '1':
          $network = new Local(1);
        break;
        case '2':
          $network = new Facebook(2);
        break;
        case '3':
          $network = new Google(3);
        break;

        default:
          return ['success' => false, 'reason' => 'Wrong social network'];
      }

      return $network->logout();
    }
}