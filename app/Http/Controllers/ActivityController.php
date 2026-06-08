<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDailyActivityRequest;
use App\Http\Requests\UpdateDailyActivityRequest;
use App\Models\DailyActivity;
use App\Support\WeeklyReportFixtures;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index(): RedirectResponse
    {
        return redirect()->route('activities.create');
    }

    public function create(Request $request): View
    {
        return $this->formView($request);
    }

    public function edit(Request $request, DailyActivity $activity): View
    {
        $this->authorizeActivity($request, $activity);

        return $this->formView($request, $activity);
    }

    public function store(StoreDailyActivityRequest $request): RedirectResponse
    {
        // Logic flow: simpan aktivitas harian ke daily_activities
        $data = $request->validated();

        \App\Models\DailyActivity::create([
            'user_id' => $request->user()->id,
            'tanggal' => $data['tanggal'],
            'aktivitas' => $data['aktivitas'],
            'status' => $data['status'],
            'keterangan' => $data['keterangan'] ?? null,
        ]);

        return redirect()
            ->route('activities.create')
            ->with('status', 'Aktivitas harian berhasil disimpan.');
    }

    public function update(UpdateDailyActivityRequest $request, DailyActivity $activity): RedirectResponse
    {
        $this->authorizeActivity($request, $activity);

        $data = $request->validated();

        $activity->update([
            'tanggal' => $data['tanggal'],
            'aktivitas' => $data['aktivitas'],
            'status' => $data['status'],
            'keterangan' => $data['keterangan'] ?? null,
        ]);

        return redirect()
            ->route('activities.create')
            ->with('status', 'Aktivitas harian berhasil diperbarui.');
    }

    public function destroy(Request $request, DailyActivity $activity): RedirectResponse
    {
        $this->authorizeActivity($request, $activity);

        $activity->delete();

        return redirect()
            ->route('activities.create')
            ->with('status', 'Aktivitas harian berhasil dihapus.');
    }

    protected function formView(Request $request, ?DailyActivity $editingActivity = null): View
    {
        $user = $request->user();

        $activities = DailyActivity::query()
            ->with('user')
            ->when($user->role !== 'admin', fn ($query) => $query->where('user_id', $user->id))
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->get();

        return view('activities.create', [
            'pageTitle' => $editingActivity ? 'Edit Aktivitas' : 'Input Aktivitas',
            'pageLead' => $editingActivity
                ? 'Perbarui catatan harianmu dengan detail yang sudah disesuaikan.'
                : 'Catat pekerjaan harian dengan format yang simple dan jelas.',
            'drafts' => WeeklyReportFixtures::draftActivities(),
            'defaultDate' => now()->toDateString(),
            'activities' => $activities,
            'editingActivity' => $editingActivity,
        ]);
    }

    protected function authorizeActivity(Request $request, DailyActivity $activity): void
    {
        $user = $request->user();

        abort_unless($user->role === 'admin' || $activity->user_id === $user->id, 403);
    }
}
