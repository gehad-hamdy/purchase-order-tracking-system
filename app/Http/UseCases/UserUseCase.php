<?php

namespace App\Http\UseCases;

use App\Http\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

class UserUseCase
{
   private $userRepository;

   public function __construct(UserRepository $userRepository)
   {
       $this->userRepository = $userRepository;
   }

   public function createUser($data) {
     $data['password'] = Hash::make($data['password']);

     return $this->userRepository->createUser($data);
   }

   public function getUser($email) {
    return $this->userRepository->getUser($email);
   }
}
