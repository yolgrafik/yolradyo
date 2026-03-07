<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = AdminActivityLog::with('admin')->orderByDesc('created_at');

        if ($request->filled('admin_id')) {
            $query->where('admin_id', $request->admin_id);
        }
        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }
        if ($request->filled('keyword')) {
            $kw = $request->keyword;
            $query->where(function ($q) use ($kw) {
                $q->where('action', 'like', "%{$kw}%")
                    ->orWhere('meta', 'like', "%{$kw}%");
            });
        }

        $logs = $query->paginate(50)->withQueryString();

        $admins = \App\Models\Admin::orderBy('name')->get(['id', 'name']);

        return view('admin.activity_logs.index', compact('logs', 'admins'));
    }
}
