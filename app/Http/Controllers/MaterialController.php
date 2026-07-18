<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\Categoria;

class MaterialController extends Controller
{
    public function index(Request $request)
    {
        $query = Material::with('categoria');

        if ($request->filled('q')) {

            $query->where(function ($q) use ($request) {

                $q->where('codigo', 'like', '%' . $request->q . '%')
                  ->orWhere('nombre', 'like', '%' . $request->q . '%')
                  ->orWhere('marca', 'like', '%' . $request->q . '%')
                  ->orWhere('modelo', 'like', '%' . $request->q . '%');

            });
        }

        if ($request->filled('categoria')) {

            $query->where(
                'categoria_id',
                $request->categoria
            );
        }

        if ($request->filled('unidad')) {

            $query->where(
                'unidad',
                $request->unidad
            );
        }


        if ($request->estado === 'ok') {

            $query->whereColumn(
                'stock_actual',
                '>',
                'stock_minimo'
            );

        } elseif ($request->estado === 'low') {

            $query->whereColumn(
                'stock_actual',
                '<=',
                'stock_minimo'
            )
            ->where('stock_actual', '>', 0);

        } elseif ($request->estado === 'empty') {

            $query->where('stock_actual', '<=', 0);
        }


        $materiales = $query
            ->latest()
            ->paginate(10);

        $stats = Material::selectRaw('count(*) as total')
            ->selectRaw('sum(case when stock_actual > stock_minimo then 1 else 0 end) as disponibles')
            ->selectRaw('sum(case when stock_actual <= stock_minimo and stock_actual > 0 then 1 else 0 end) as stock_bajo')
            ->selectRaw('sum(case when stock_actual <= 0 then 1 else 0 end) as agotados')
            ->first()
            ->toArray();

        $categorias = Categoria::orderBy('nombre')
            ->get();

        $unidades = Material::select('unidad')
            ->distinct()
            ->orderBy('unidad')
            ->pluck('unidad');

        return view(
            'admin.material.index',
            compact(
                'materiales',
                'categorias',
                'unidades',
                'stats'
            )
        );
    }
}
