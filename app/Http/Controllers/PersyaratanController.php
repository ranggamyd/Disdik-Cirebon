<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persyaratan;
use DB;

class PersyaratanController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()) {
            return Persyaratan::dataTable($request);
        }

        return view('admin.persyaratan.index', [
            'title'         => 'Persyaratan',
            'breadcrumbs'   => [
                [
                    'title' => 'Persyaratan',
                    'link'  => route('persyaratan')
                ]
            ]
        ]);
    }


    public function create()
    {
        return view('admin.persyaratan.create', [
            'title'         => 'Tambah Persyaratan',
            'breadcrumbs'   => [
                [
                    'title' => 'Persyaratan',
                    'link'  => route('persyaratan')
                ],
                [
                    'title' => 'Tambah Persyaratan',
                    'link'  => route('persyaratan.create')
                ]
            ]
        ]);
    }


    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            Persyaratan::createPersyaratan($request->all());
            DB::commit();

            return \Res::save();
        } catch (\Exception $e) {
            DB::rollback();

            return \Res::error($e);
        }
    }


    public function edit(Persyaratan $persyaratan)
    {
        return view('admin.persyaratan.edit', [
            'title'         => 'Edit Persyaratan',
            'persyaratan'    => $persyaratan,
            'breadcrumbs'   => [
                [
                    'title' => 'Persyaratan',
                    'link'  => route('persyaratan')
                ],
                [
                    'title' => 'Edit Persyaratan',
                    'link'  => route('persyaratan.edit', $persyaratan->id_persyaratan)
                ]
            ]
        ]);
    }


    public function update(Request $request, Persyaratan $persyaratan)
    {
        DB::beginTransaction();

        try {
            $persyaratan->updatePersyaratan($request->all());
            DB::commit();

            return \Res::update();
        } catch (\Exception $e) {
            DB::rollback();

            return \Res::error($e);
        }
    }


    public function destroy(Persyaratan $persyaratan)
    {
        DB::beginTransaction();

        try {
            $persyaratan->deletePersyaratan();
            DB::commit();

            return \Res::delete();
        } catch (\Exception $e) {
            DB::rollback();

            return \Res::error($e);
        }
    }
}
