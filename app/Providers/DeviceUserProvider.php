<?php

namespace App\Providers;

use App\Device;
use Carbon\Carbon;
use Illuminate\Auth\GenericUser;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class DeviceUserProvider implements UserProvider {

    /**
     * Retrieve a user by their unique identifier.
     *
     * @param  mixed $identifier
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveById($identifier) { //direct access to page
        // TODO: Implement retrieveById() method.
        $qry = Device::where('kode_perangkat','=',$identifier);
        if ($qry->count() >0) {
            $user = $qry->select('*')->first();
            $attributes = array(
                'kode_perangkat' => $user->kode_perangkat,
                'nama_perangkat' => $user->nama_perangkat,
                'kata_sandi_perangkat' => $user->kata_sandi_perangkat,
                'jenis_kelamin_perangkat' => $user->jenis_kelamin_perangkat,
                'gambar_perangkat' => $user->gambar_perangkat,
                'kode_otoritas' => $user->kode_otoritas,
            );
            return $user;
        }
        return null;
    }

    /**
     * Retrieve a user by by their unique identifier and "remember me" token.
     *
     * @param  mixed $identifier
     * @param  string $token
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByToken($identifier, $token) {
        // TODO: Implement retrieveByToken() method.
        $qry = Device::where('kode_perangkat','=',$identifier)
            ->where('remember_token','=',$token);

        if($qry->count() >0) {
            $user = $qry->select('*')->first();
            $attributes = array(
                'kode_perangkat' => $user->kode_perangkat,
                'nama_perangkat' => $user->nama_perangkat,
                'kata_sandi_perangkat' => $user->kata_sandi_perangkat,
                'jenis_kelamin_perangkat' => $user->jenis_kelamin_perangkat,
                'gambar_perangkat' => $user->gambar_perangkat,
                'kode_otoritas' => $user->kode_otoritas,
            );
            return $user;
        }
        return null;
    }

    /**
     * Update the "remember me" token for the given user in storage.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable $user
     * @param  string $token
     * @return void
     */
    public function updateRememberToken(Authenticatable $user, $token) {
        // TODO: Implement updateRememberToken() method.

        //not yet use remember token
        //$user->setRememberToken($token);
        //$user->save();
    }

    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials) { //this is currently used
        // TODO: Implement retrieveByCredentials() method.
        $qry = Device::where('kode_perangkat','=',$credentials['kode_perangkat']);
        if($qry->count() > 0) {
            $user = $qry->select('*')->first();
            return $user;
        }
        return null;
    }

    /**
     * Validate a user against the given credentials.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable $user
     * @param  array $credentials
     * @return bool
     */
    public function validateCredentials(Authenticatable $user, array $credentials) { //this is currently used
        // TODO: Implement validateCredentials() method.
        // we'll assume if a user was retrieved, it's good

        // DIFFERENT THAN ORIGINAL ANSWER
        if ($user->kode_perangkat == $credentials['kode_perangkat'] && Hash::check($credentials['kata_sandi_perangkat'], $user->getAuthPassword())) {
            $user->save();
            return true;
        }
        return false;
    }
}
