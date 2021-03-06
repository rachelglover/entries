<?php

namespace App;

use Laravel\Socialite\Contracts\User as ProviderUser;

class SocialAccountService {

    public function createOrGetUser(ProviderUser $providerUser) {

        $account = SocialAccount::whereProvider('facebook')
                    ->whereProviderUserId($providerUser->getId())
                    ->first();

        if ($account) {
            return $account->user;
        } else {
            $account = new SocialAccount([
                'provider_user_id' => $providerUser->getId(),
                'provider' => 'facebook'
            ]);

            $user = User::whereEmail($providerUser->getEmail())->first();

            if (!$user) {
                //Split the name into firstname and lastname
                $fullname = $providerUser->getName();
                $namelist = preg_split('/ /',$fullname);
                $firstname = $namelist[0];
                $lastname = "";
                for ($i=1; $i<count($namelist);$i++ ) {
                    $lastname = $lastname . " " . $namelist[$i];
                }
                $user = User::create([
                    'email' => $providerUser->getEmail(),
                    'firstname' => $firstname,
                    'lastname' => $lastname,
                    'password' => 'SocialUsers'.date('YYmmddHHiiss').rand(6,11),
                ]);
            }

            $account->user()->associate($user);
            $account->save();

            return $user;
        }
    }
}