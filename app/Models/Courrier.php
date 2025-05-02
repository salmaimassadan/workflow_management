<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Courrier extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference',
        'type',
        'subject',
        'content',
        'status',
        'sender',
        'recipient',
        'document',
        'created_at',
        'created_by', // Add this line to allow mass assignment of the created_by field
    ];

    /**
     * Get the transactions for the courrier.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Get the documents for the courrier.
     */
    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    /**
     * The dossiers that belong to the courrier.
     */
    public function dossiers()
    {
        return $this->belongsToMany(Dossier::class, 'courrier_dossier');
    }

    /**
     * Accessor to format the content for display.
     *
     * @return string
     */
    public function getFormattedContentAttribute()
    {
        return nl2br(e($this->content));
    }

    /**
     * Accessor to get the status as a label.
     *
     * @return string
     */
    public function getStatusLabelAttribute()
    {
        $statusLabels = [
            'new' => 'New',
            'in_progress' => 'In Progress',
            'completed' => 'Completed',
            'archived' => 'Archived',
        ];

        return $statusLabels[$this->status] ?? 'Unknown';
    }

    /**
     * Scope a query to only include courriers of a given type.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope a query to only include courriers with a specific status.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $status
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Get the notifications related to the courrier.
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * Get the employee who created the courrier.
     */
    public function createdBy()
    {
        return $this->belongsTo(Employee::class, 'created_by');
    }
    public function templates()
{
    return $this->hasMany(CourrierTemplate::class);
}

}
