<?php

namespace App\Livewire\Patient;

use App\Models\Message;
use App\Models\PatientNotification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\User;
use App\Models\Appointment;
use Livewire\WithPagination;

class Messages extends Component
{
    use WithPagination;

    public $user = [];
    public $user_id;
    public $patient;
    public $appointment_id;
    public $activeTab = 'messages'; // 'messages' або 'notifications'

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

    public function render()
    {
        $messages = Message::where('user_id', $this->user_id)
            ->with(['doctor.user'])
            ->orderBy('created_at')
            ->paginate(5);

        $notifications = PatientNotification::where('user_id', $this->user_id)
            ->with(['doctor.user', 'promotion'])
            ->orderBy('created_at', 'desc')
            ->paginate(5, ['*'], 'notifications_page');

        $unreadCount = PatientNotification::where('user_id', $this->user_id)
            ->where('is_read', false)
            ->count();

        return view('livewire.patient.messages', [
            'messages' => $messages,
            'notifications' => $notifications,
            'unreadCount' => $unreadCount,
        ]);
    }
}
