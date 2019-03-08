<?php
namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{ 
  public function index() {
    $users = User::all();

    return $users;
  }

  public function bla(Request $request) {
    return ['bla'];
  }
}