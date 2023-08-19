<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'user';
    protected $fillable = [ 'id_user', 'nama', 'username', 'email', 'password', 'role' ];
    protected $primaryKey = 'id_user';


    /**
     *  CRUD methods
     * */
    public static function createUser(array $request)
    {
        $user = self::create($request);
        return $user;
    }

    public function updateUser($request)
    {
        $this->update([
            'nama'      => $request->nama,
            'username'  => $request->username,
            'email'     => $request->email,
            'role'      => $request->role,
        ]);

        if(!empty($request->password)) {
            $this->update([
                'password'  => $request->password,
            ]);
        }

        return $this;
    }

    public function deleteUser()
    {
        return $this->delete();
    }



    /**
     *  Static methods
     * */
    public static function dataTable($request)
    {
        $data = self::select([ 'user.*' ]);

        return \Datatables::eloquent($data)
                ->addColumn('action', function($data){
                    $action = '
                    <div class="dropdown">
                        <button class="btn btn-primary px-2 py-1 dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Pilih Aksi
                        </button>
                        <div class="dropdown-menu">

                            <a class="dropdown-item" href="'.route('user.edit', $data->id_user).'">
                                <i class="fas fa-pencil-alt mr-1"></i> Edit
                            </a>

                            <a class="dropdown-item delete" href="javascript:void(0)" data-delete-message="Yakin ingin menghapus <strong>'.$data->nama_lengkap.'</strong>?" data-delete-href="'.route('user.destroy', $data->id_user).'">
                                <i class="fas fa-trash mr-1"></i> Hapus
                            </a>

                        </div>
                    </div>';
                    return $action;
                })
                ->rawColumns([ 'action' ])
                ->make(true);
    }
}
