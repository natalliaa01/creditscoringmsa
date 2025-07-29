<?php

namespace App\Http\Controllers;

use App\Models\EconomicSector;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EconomicSectorController extends Controller
{
    public function __construct()
    {
        // Hanya Admin yang bisa mengakses controller ini
        $this->middleware('can:manage master data');
    }

    /**
     * Menampilkan daftar sektor ekonomi.
     */
    public function index()
    {
        $sectors = EconomicSector::all();
        return view('economic_sectors.index', compact('sectors'));
    }

    /**
     * Menampilkan form untuk membuat sektor ekonomi baru.
     */
    public function create()
    {
        return view('economic_sectors.create');
    }

    /**
     * Menyimpan sektor ekonomi baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:economic_sectors'],
            'description' => ['nullable', 'string'],
        ]);

        EconomicSector::create($request->all());

        return redirect()->route('economic-sectors.index')->with('success', 'Sektor ekonomi berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail sektor ekonomi (opsional, bisa digabung dengan edit).
     */
    public function show(EconomicSector $economicSector)
    {
        return view('economic_sectors.show', compact('economicSector'));
    }

    /**
     * Menampilkan form untuk mengedit sektor ekonomi.
     */
    public function edit(EconomicSector $economicSector)
    {
        return view('economic_sectors.edit', compact('economicSector'));
    }

    /**
     * Memperbarui sektor ekonomi di database.
     */
    public function update(Request $request, EconomicSector $economicSector)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('economic_sectors')->ignore($economicSector->id)],
            'description' => ['nullable', 'string'],
        ]);

        $economicSector->update($request->all());

        return redirect()->route('economic-sectors.index')->with('success', 'Sektor ekonomi berhasil diperbarui!');
    }

    /**
     * Menghapus sektor ekonomi dari database.
     */
    public function destroy(EconomicSector $economicSector)
    {
        $economicSector->delete();
        return redirect()->route('economic-sectors.index')->with('success', 'Sektor ekonomi berhasil dihapus!');
    }
}
