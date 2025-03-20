<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $fillable = [
        'sound_id',
        'user_id',
        'complaint_type', // 'copyright', 'inappropriate', etc.
        'description',
        'status' // 'pending', 'resolved', 'dismissed'
    ];
    public static $complaint_type = [
        'inaccurate' => 'Inaccurate Information',
        'incomplete' => 'Incomplete Content',
        'outdated' => 'Outdated Information',
        'inappropriate' => 'Inappropriate Content',
        'other' => 'Other Issue'
    ];

    public function getComplaintTypeName()
    {
        return self::$complaint_type[$this->complaint_type] ?? 'Unknown';
    }

    /**
     * The complaint statuses available.
     *
     * @var array
     */
    public static $statuses = [
        'pending' => 'Pending Review',
        'approved' => 'Approved',
        'dismissed' => 'Dismissed'
    ];

    public function getComplaintStatusName() 
    {
        return self::$statuses[$this->status] ??  'Unknown';
    }

    public function getComplaintStatusKey() 
    {
        $statusValue = $this->getComplaintStatusName(); 
        return array_search($statusValue, self::$statuses);
    }

    /**
     * Get the manual that was complained about.
     */
    public function sound()
    {
        return $this->belongsTo(Sound::class);
    }

    /**
     * Get the user who made the complaint.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include pending complaints.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include resolved complaints.
     */
    public function scopeResolved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope a query to only include dismissed complaints.
     */
    public function scopeDismissed($query)
    {
        return $query->where('status', 'dismissed');
    }
}
