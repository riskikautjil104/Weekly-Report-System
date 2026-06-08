<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\DailyActivity;
use App\Services\WhatsAppLinkService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request, WhatsAppLinkService $whatsAppLinkService): View
    {
        $user = $request->user();
        $weekStart = Carbon::now()->startOfWeek();
        $weekEnd = Carbon::now()->endOfWeek();
        $weekActivities = DailyActivity::query()
            ->where('user_id', $user->id)
            ->whereBetween('tanggal', [$weekStart->toDateString(), $weekEnd->toDateString()])
            ->get();

        return view('profile.edit', [
            'user' => $user,
            'initials' => $this->initials($user->name),
            'summary' => [
                'week_label' => $weekStart->translatedFormat('d M Y') . ' - ' . $weekEnd->translatedFormat('d M Y'),
                'total' => $weekActivities->count(),
                'selesai' => $weekActivities->where('status', 'selesai')->count(),
                'progress' => $weekActivities->where('status', 'progress')->count(),
                'kendala' => $weekActivities->where('status', 'kendala')->count(),
            ],
            'whatsappLink' => $whatsAppLinkService->build(
                $user->whatsapp_number,
                'Halo ' . $user->name . ', saya ingin mengirim update aktivitas harian weekly report.'
            ),
            'whatsappNumber' => $whatsAppLinkService->normalize($user->whatsapp_number),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    protected function initials(?string $name): string
    {
        $parts = preg_split('/\s+/', trim((string) $name)) ?: [];
        $letters = array_map(fn ($part) => mb_substr($part, 0, 1), array_slice($parts, 0, 2));

        return strtoupper(implode('', $letters)) ?: 'U';
    }
}
