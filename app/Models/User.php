<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
// use HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable , HasRoles;

//    /**
//     * The attributes that are mass assignable.
//     *
//     * @var array<int, string>
//     */
//    protected $fillable = [
//        'name',
//        'email',
//        'password',
//    ];
    protected $guarded =[];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
//    public function isWorking()
//    {
//
//        $attendance = $this->attendances()
//            ->where('attendance_date', now()->toDateString())
//            ->first();
//
//        return $attendance && $attendance->start_time && !$attendance->departure_time;
//    }
    public function salary()
    {
        return $this->hasOne(Salary::class);
    }
    public function advances()
    {
        return $this->hasMany(Advance::class);
    }
    public function monthly_summary()
    {
        return $this->hasMany(MonthlySummary::class);
    }
}
