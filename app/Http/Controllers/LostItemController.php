<?php

namespace App\Http\Controllers;

use App\Models\LostItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class LostItemController extends Controller
{
    private const CATEGORIES = [
        'Elektronik',
        'Dokumen',
        'Aksesori',
        'Kunci',
        'Lainnya',
    ];

    public function create()
    {
        return view('lost-items.create', [
            'categories' => self::CATEGORIES,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_name' => ['required', 'string', 'max:120'],
            'category' => ['required', 'string', Rule::in(self::CATEGORIES)],
            'incident_date' => ['required', 'date', 'before_or_equal:today'],
            'location' => ['required', 'string', 'max:180'],
            'description' => ['required', 'string', 'max:1000'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:10240'],
            'reporter_name' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'string', 'max:30'],
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo_path'] = $request->file('photo')->store('lost-items', 'public');
        }

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'menunggu_verifikasi';

        LostItem::create($validated);

        return redirect()
            ->route('lost-items.create')
            ->with('success', 'Laporan barang hilang berhasil dikirim dan menunggu verifikasi.');
    }
}
