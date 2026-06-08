<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KaryawanController extends Controller
{
    // Index dengan search dan filter
    public function index(Request $request)
    {
        $query = User::where('role', 'karyawan');
        
        // Filter berdasarkan nama (search)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }
        
        // Filter berdasarkan cabang
        if ($request->filled('cabang')) {
            $query->where('cabang', $request->cabang);
        }
        
        // Urutkan berdasarkan nama
        $karyawan = $query->orderBy('name')->paginate(10);
        
        return view('admin.karyawan.index', compact('karyawan'));
    }
    
    public function create()
    {
        return view('admin.karyawan.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'cabang' => 'required',
        ]);
        
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'karyawan',
            'cabang' => $request->cabang,
            'fb_url' => $request->fb_url,
            'ig_url' => $request->ig_url,
            'wa_number' => $request->wa_number,
        ]);
        
        return redirect()->route('admin.karyawan')->with('success', 'Karyawan berhasil ditambahkan');
    }
    
    public function edit($id)
    {
        $karyawan = User::findOrFail($id);
        return view('admin.karyawan.edit', compact('karyawan'));
    }
    
    public function update(Request $request, $id)
    {
        $karyawan = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$id,
            'cabang' => 'required',
        ]);
        
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'cabang' => $request->cabang,
            'fb_url' => $request->fb_url,
            'ig_url' => $request->ig_url,
            'wa_number' => $request->wa_number,
        ];
        
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        
        $karyawan->update($data);
        
        return redirect()->route('admin.karyawan')->with('success', 'Karyawan berhasil diupdate');
    }
    
    public function destroy($id)
    {
        $karyawan = User::findOrFail($id);
        $karyawan->delete();
        
        return redirect()->route('admin.karyawan')->with('success', 'Karyawan berhasil dihapus');
    }
}