<?php

namespace App\Livewire;

use App\Models\Attendance;
use Illuminate\Support\Carbon;
use Livewire\Component;

class RecordWorkTime extends Component
{
    public $userId;

    public function mount($userId)
    {
        $this->userId = $userId;
    }

    public function recordStartTime()
    {
        Attendance::create([
            'user_id' => $this->userId,
            'attendance_date' => now()->toDateString(),
            'start_time' => now()->toTimeString(),
        ]);

        $this->emit('refreshParent');
    }

    public function recordEndTime()
    {
        $attendance = Attendance::where('user_id', $this->userId)
            ->where('attendance_date', now()->toDateString())
            ->latest()
            ->first();

        if ($attendance && !$attendance->departure_time) {
            $attendance->update([
                'departure_time' => now()->toTimeString(),
                'working_hours' => $this->calculateWorkingHours($attendance->start_time),
            ]);

            $this->emit('refreshParent');
        }
    }

    private function calculateWorkingHours($startTime)
    {
        $start = Carbon::parse($startTime);
        $end = now();
        return $end->diffInHours($start) + $end->diffInMinutes($start) / 60;
    }

    public function render()
    {
        return view('livewire.record-work-time');
    }

}
