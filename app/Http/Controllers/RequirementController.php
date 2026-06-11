<?php

namespace App\Http\Controllers;

use App\Models\Requirement;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class RequirementController extends Controller
{
    private const AFFECTED_MENU_ITEMS = ['Pendaftaran','Rawat Jalan','Rawat Inap','Farmasi','Logistik','Radiologi','Laboratorium','Kasir','Laporan','Lainnya'];
private const DATA_IMPACT_ITEMS   = ['Stok Barang','Data Pasien','Laporan','Billing','Integrasi BPJS','Integrasi SATUSEHAT','Tidak Ada'];
private const LAMPIRAN_ITEMS      = ['Screenshot','Mockup','Coretan Manual','Referensi Sistem Lain'];
private const RISIKO_ITEMS        = ['Data','Stok','Laporan','Integrasi Sistem','Proses Operasional'];

private function buildChecklistField(Request $request, string $itemsKey, string $noteKey, array $allItems, string $label = 'Keterangan'): ?string
{
    if (!$request->has($itemsKey) && !$request->filled($noteKey)) {
        return null;
    }

    $selected = (array) $request->input($itemsKey, []);
    $lines = [];

    foreach ($allItems as $item) {
        $mark = in_array($item, $selected, true) ? '[x]' : '[ ]';
        $lines[] = "{$mark} {$item}";
    }

    $lines[] = '';
    $lines[] = $label . ': ' . $request->string($noteKey)->toString();

    return implode("\n", $lines);
}

private function applyChecklistFields(Request $request, array &$data): void
{
    $value = $this->buildChecklistField($request, 'affected_menu_items', 'affected_menu_keterangan', self::AFFECTED_MENU_ITEMS);
    if ($value !== null) {
        $data['affected_menu'] = $value;
    }

    $value = $this->buildChecklistField($request, 'impact_analysis_items', 'impact_analysis_keterangan', self::DATA_IMPACT_ITEMS);
    if ($value !== null) {
        $data['impact_analysis'] = $value;
    }

    $value = $this->buildChecklistField($request, 'uiux_notes_items', 'uiux_notes_keterangan', self::LAMPIRAN_ITEMS);
    if ($value !== null) {
        $data['uiux_notes'] = $value;
    }

    $value = $this->buildChecklistField($request, 'potential_risk_items', 'potential_risk_keterangan', self::RISIKO_ITEMS, 'Catatan');
    if ($value !== null) {
        $data['potential_risk'] = $value;
    }
}
    public function index(Request $request)
    {
        $query = Requirement::query()->with('user');

        $requirements = $query
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('requirements.index', [
            'pageTitle' => 'Requirements Gathering',
            'requirements' => $requirements,
            'isAdmin' => $request->user()?->role === 'admin',
        ]);
    }

    public function create()
    {
        return view('requirements.create', [
            'pageTitle' => 'Buat Requirement',
            'categories' => ['feature', 'change', 'bug', 'enhancement'],
            'statuses' => ['draft', 'submitted', 'need_clarification', 'approved', 'rejected'],
        ]);
    }

public function store(Request $request)
{
    $request->validate([
        'title' => ['required', 'string', 'max:255'],
        'category' => ['required', 'string', 'max:50'],
        'body' => ['nullable', 'string'],
        'business_rules' => ['nullable', 'string'],

        'request_number' => ['nullable', 'string', 'max:255'],
        'request_date' => ['nullable', 'date'],
        'department' => ['nullable', 'string', 'max:255'],
        'requester_title' => ['nullable', 'string', 'max:255'],
        'contact_number' => ['nullable', 'string', 'max:255'],

        'current_workflow' => ['nullable', 'string'],
        'expected_workflow' => ['nullable', 'string'],
        'business_goal' => ['nullable', 'string'],
        'expected_benefits' => ['nullable', 'string'],
        'field_changes' => ['nullable', 'string'],
        'priority' => ['nullable', 'string', 'max:255'],
        'priority_reason' => ['nullable', 'string'],
        'validation_rules' => ['nullable', 'string'],
    ]);

    $data = $request->only([
        'title', 'category', 'body', 'business_rules',
        'request_number', 'department', 'requester_title', 'contact_number',
        'current_workflow', 'expected_workflow', 'business_goal', 'expected_benefits',
        'field_changes', 'priority', 'priority_reason', 'validation_rules',
    ]);

    $data['title'] = $request->string('title')->toString();
    $data['category'] = $request->string('category')->toString();
    $data['request_date'] = $request->filled('request_date')
        ? $request->date('request_date')->toDateString()
        : null;

    $this->applyChecklistFields($request, $data);

    $data['user_id'] = $request->user()->id;
    $data['status'] = 'submitted';

    $requirement = Requirement::create($data);

    return redirect()->route('requirements.show', $requirement)->with('success', 'Requirement dibuat dan dikirim untuk review.');
}

    public function show(Requirement $requirement, Request $request)
    {
        $isAdmin = $request->user()?->role === 'admin';
        // Akses dibuka untuk semua user & admin

        $requirement->load(['user', 'comments.user']);

        return view('requirements.show', [
            'pageTitle' => 'Detail Requirement',
            'requirement' => $requirement,
            'isAdmin' => $isAdmin,
        ]);
    }

    public function print(Requirement $requirement, Request $request)
    {
        $isAdmin = $request->user()?->role === 'admin';
        // Akses dibuka untuk semua user & admin

        $requirement->load(['user', 'comments.user']);

        return view('requirements.print', [
            'pageTitle' => 'Requirement PDF',
            'requirement' => $requirement,
            'isAdmin' => $isAdmin,
        ]);
    }

    public function edit(Requirement $requirement, Request $request)
    {
        // Akses dibuka untuk semua user & admin

        return view('requirements.edit', [
            'pageTitle' => 'Edit Requirement',
            'requirement' => $requirement->load(['user', 'comments.user']),
            'isAdmin' => $request->user()?->role === 'admin',
            'categories' => ['feature', 'change', 'bug', 'enhancement'],
            'statuses' => ['draft', 'submitted', 'need_clarification', 'approved', 'rejected'],
        ]);
    }

    public function update(Request $request, Requirement $requirement)
    {
        // Akses dibuka untuk semua user & admin

        $isAdmin = $request->user()?->role === 'admin';

        // Status bisa diubah oleh semua user
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:50'],
            'body' => ['nullable', 'string'],
            'impact_analysis' => ['nullable', 'string'],
            'business_rules' => ['nullable', 'string'],

            // fields template
            'request_number' => ['nullable', 'string', 'max:255'],
            'request_date' => ['nullable', 'date'],
            'department' => ['nullable', 'string', 'max:255'],
            'requester_title' => ['nullable', 'string', 'max:255'],
            'contact_number' => ['nullable', 'string', 'max:255'],

            'current_workflow' => ['nullable', 'string'],
            'expected_workflow' => ['nullable', 'string'],
            'business_goal' => ['nullable', 'string'],
            'expected_benefits' => ['nullable', 'string'],
            'affected_menu' => ['nullable', 'string'],
            'field_changes' => ['nullable', 'string'],
            'potential_risk' => ['nullable', 'string'],
            'priority' => ['nullable', 'string', 'max:255'],
            'priority_reason' => ['nullable', 'string'],
            'validation_rules' => ['nullable', 'string'],
            'uiux_notes' => ['nullable', 'string'],
        ]);

        $data = $request->only([
            'title',
            'category',
            'body',
            'impact_analysis',
            'business_rules',

            'request_number',
            'request_date',
            'department',
            'requester_title',
            'contact_number',

            'current_workflow',
            'expected_workflow',
            'business_goal',
            'expected_benefits',
            'affected_menu',
            'field_changes',
            'potential_risk',
            'priority',
            'priority_reason',
            'validation_rules',
            'uiux_notes',
        ]);

        $data['title'] = $request->string('title')->toString();
        $data['category'] = $request->string('category')->toString();

        foreach (['body', 'impact_analysis', 'business_rules', 'current_workflow', 'expected_workflow', 'business_goal', 'expected_benefits', 'affected_menu', 'field_changes', 'potential_risk', 'priority_reason', 'validation_rules', 'uiux_notes'] as $k) {
            if ($request->filled($k)) {
                $data[$k] = $request->string($k)->toString();
            } else {
                $data[$k] = null;
            }
        }

        if ($request->filled('request_number')) $data['request_number'] = $request->string('request_number')->toString();
        if ($request->filled('department')) $data['department'] = $request->string('department')->toString();
        if ($request->filled('requester_title')) $data['requester_title'] = $request->string('requester_title')->toString();
        if ($request->filled('contact_number')) $data['contact_number'] = $request->string('contact_number')->toString();
        if ($request->filled('priority')) $data['priority'] = $request->string('priority')->toString();

        if ($request->filled('request_date')) {
            $data['request_date'] = $request->date('request_date')->toDateString();
        } else {
            $data['request_date'] = null;
        }
$this->applyChecklistFields($request, $data);

$requirement->fill($data);
        $requirement->fill($data);

        // Simpan comment/discussion untuk semua user (tidak tergantung status)
        $comment = $request->input('comment');
        $status = $request->input('status');

        if ($status !== null) {
            $request->validate([
                'status' => ['required', 'string', 'max:50'],
            ]);
            $requirement->status = $request->string('status')->toString();
        }

        $requirement->save();

        if (!blank($comment)) {

            $request->validate([
                'comment' => ['nullable', 'string', 'max:20000'],
            ]);

            $requirement->comments()->create([
                'user_id' => $request->user()->id,
                'body' => $request->string('comment')->toString(),
            ]);
        }


        return back()->with('success', 'Requirement diperbarui.');
    }
}
