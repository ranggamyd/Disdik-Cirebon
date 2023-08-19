<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persyaratan extends Model
{
    protected $table = 'persyaratan';
    protected $fillable = [ 'nama_persyaratan', 'id_pendidikan', 'tipe_input', 'is_required', 'opsi_multiple' ];
    protected $primaryKey = 'id_persyaratan';


    /**
     *  Relationship methods
     * */
    public function pendidikan()
    {
        return $this->belongsTo('App\Models\Pendidikan', 'id_pendidikan');
    }



    /**
     *  CRUD methods
     * */
    public static function createPersyaratan(array $request)
    {
        return self::create($request);
    }

    public function updatePersyaratan(array $request)
    {
        $this->update($request);
        return $this;
    }

    public function deletePersyaratan()
    {
        return $this->delete();
    }


    /**
     *  Helper
     * */
    public function opsiMultiple()
    {
        $opsi = [];
        foreach(explode("\n", $this->opsi_multiple) as $op) {
            if(trim($op)) {
                $opsi[] = $op;
            }
        }

        return $opsi;
    }


    /**
     *  Static methods
     * */
    public static function dataTable($request)
    {
        $data = self::select([ 'persyaratan.*' ])
                    ->with([ 'pendidikan' ]);

        return datatables()->eloquent($data)
            ->addColumn('status', function($data){
                return 'Aktif';
            })
            ->addColumn('action', function ($data) {
                $action = '
                    <div class="dropdown">
                        <button class="btn btn-primary px-2 py-1 dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Pilih Aksi
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="'.route('persyaratan.edit', $data->id_persyaratan).'">
                                <i class="fas fa-pencil-alt mr-1"></i> Edit
                            </a>
                            <a class="dropdown-item delete" href="javascript:void(0)" data-delete-message="Yakin ingin menghapus?" data-delete-href="'.route('persyaratan.destroy', $data->id_persyaratan).'">
                                <i class="fas fa-trash mr-1"></i> Hapus
                            </a>
                        </div>
                    </div>';
                return $action;
            })
            ->rawColumns([ 'action' ])
            ->addIndexColumn()
            ->make(true);
    }
}
