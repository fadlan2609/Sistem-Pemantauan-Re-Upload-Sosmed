<?php

namespace App\Http\Controllers;

use App\Models\MonthlyContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KontenController extends Controller
{
    public function index()
    {
        $konten = MonthlyContent::with('creator')->orderBy('month_year', 'desc')->get();
        return view('admin.konten.index', compact('konten'));
    }
    
    public function create()
    {
        return view('admin.konten.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'month_year' => 'required|date',
            'deadline_date' => 'required|date',
            'platform' => 'required',
            'original_link' => 'required|url',
        ]);
        
        MonthlyContent::create([
            'month_year' => $request->month_year,
            'deadline_date' => $request->deadline_date,
            'platform' => $request->platform,
            'original_link' => $request->original_link,
            'description' => $request->description,
            'created_by' => Auth::id(),
        ]);
        
        return redirect()->route('admin.konten')->with('success', 'Konten berhasil ditambahkan');
    }
    
    public function edit($id)
    {
        $konten = MonthlyContent::findOrFail($id);
        return view('admin.konten.edit', compact('konten'));
    }
    
    public function update(Request $request, $id)
    {
        $konten = MonthlyContent::findOrFail($id);
        
        $request->validate([
            'month_year' => 'required|date',
            'deadline_date' => 'required|date',
            'platform' => 'required',
            'original_link' => 'required|url',
        ]);
        
        $konten->update($request->all());
        
        return redirect()->route('admin.konten')->with('success', 'Konten berhasil diupdate');
    }
    
    public function destroy($id)
    {
        $konten = MonthlyContent::findOrFail($id);
        $konten->delete();
        
        return redirect()->route('admin.konten')->with('success', 'Konten berhasil dihapus');
    }
}