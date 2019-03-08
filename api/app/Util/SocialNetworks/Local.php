<?php

namespace App\Util\SocialNetworks;

use Tymon\JWTAuth\JWTAuth;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use App\User;
use App\Role;
use Auth;

class Local extends SocialNetwork {

  public function validationRules()
  {
    return config('boilerplate.registration_local.validation_rules');
  }

  public function registration(Request $request) {
    parent::registration($request);

    $request->merge([
        'role_id' => Role::getDefault()->id,
        'verified_token' => $this->generateVerifiedToken(),
        'social_provider_id' => $this->socialNetworkId,
        'verified' => 1
    ]);

    $data = $request->only([
        'email', 'password', 'role_id', 'date_of_birth', 'gender_id', 'first_name', 
        'last_name', 'verified_token', 'social_provider_id', 'verified']);

    $userExits = $this->userExists($data);

    if(!$userExits['success']) {
        return $userExits;
    }

    $user = User::create($data);

    return ['success' => true];
  }

  public function login(Request $request, JWTAuth $JWTAuth) {
    $credentials = $request->only(['email', 'password']);

    try {
      $token = Auth::guard()->attempt($credentials);

      if(!$token) {
          throw new AccessDeniedHttpException();
      }

    } catch (JWTException $e) {
        throw new HttpException(500);
    }

    $requestUser = Auth::guard()->user();

    $userRoleActions = $requestUser->roles->actions()->wherePivot('is_allowed', 1)->get();

    return response()
      ->json([
          'success' => true,
          'token' => $token,
          'user' => [
              'name' => $requestUser->full_name,
              'email' => $requestUser->email,
              'role' => $requestUser->roles,
              'actions' => $userRoleActions
          ],
          'expires_in' => Auth::guard('api')->factory()->getTTL() * 60
      ]);
  }

}