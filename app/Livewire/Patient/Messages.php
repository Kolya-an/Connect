<?php

namespace App\Livewire\Patient;

use App\Models\Message;
use App\Models\PatientNotification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;
use App\Models\PhotoConsent;
use App\Models\UserSignature;

class Messages extends Component
{
    use WithPagination;

    public $user;
    public $user_id;
    public $patient;
    public $appointment_id;
    public $activeTab = 'messages';

    public function mount(User $id)
    {
        $this->user = $id;
        $this->user_id = $id->id;
        if (Auth::id() != $this->user_id) {
            abort(403, 'Доступ запрещен');
        }
        $this->patient = $this->user->patient;
    }

    public function switchTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
        $this->resetPage('notifications_page');
        $this->resetPage('signatures_page');
    }

    public function markAsRead($notificationId)
    {
        $notification = PatientNotification::where('user_id', $this->user_id)->find($notificationId);
        if ($notification) {
            $notification->update(['is_read' => true]);
        }
    }

    public function deleteNotification($notificationId)
    {
        $notification = PatientNotification::where('user_id', $this->user_id)->find($notificationId);
        if ($notification) {
            $notification->delete();
        }
    }

    public function markSignatureAsRead($signatureId)
    {
        $signature = PhotoConsent::whereHas('doctorPhoto', function ($query) {
            $query->where('patient_id', $this->patient?->id);
        })->find($signatureId);

        if ($signature && !$signature->is_read) {
            $signature->update(['is_read' => true]);
        }
    }

    public function render()
{
    $messages = Message::where('user_id', $this->user_id)
        ->with(['doctor.user'])
        ->orderBy('created_at')
        ->paginate(5);

    $signatures = PhotoConsent::whereHas('doctorPhoto', function ($query) {
            $query->where('patient_id', $this->patient?->id);
        })
        ->with(['userSignature', 'doctorPhoto.doctor.user'])
        ->orderBy('created_at', 'desc')
        ->paginate(10, ['*'], 'signatures_page');

    $notifications = PatientNotification::where('user_id', $this->user_id)
        ->with(['doctor.user', 'promotion'])
        ->orderBy('created_at', 'desc')
        ->paginate(5, ['*'], 'notifications_page');

    $unreadCount = PatientNotification::where('user_id', $this->user_id)
        ->where('is_read', false)
        ->count();

    // Підраховуємо непрочитані записи напряму з моделі UserSignature за patient_id
    $unreadSignaturesCount = UserSignature::where('user_id', $this->patient?->user_id)
        ->where('is_read', false)
        ->count();

    return view('livewire.patient.messages', [
        'messages'              => $messages,
        'signatures'            => $signatures,
        'notifications'         => $notifications,
        'unreadCount'           => $unreadCount,
        'unreadSignaturesCount' => $unreadSignaturesCount,
    ]);
}
}