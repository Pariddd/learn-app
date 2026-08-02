<?php

namespace App\Models;

use CodeIgniter\Model;

class ProgressVideoModel extends Model
{
    protected $table = 'progress_video';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = ['user_id', 'video_id', 'watch_percentage', 'status', 'updated_at'];

    public function upsertProgress(int $userId, int $videoId, float $percentage): void
    {
        $percentage = max(0, min(100, $percentage)); // clamp 0-100, cegah nilai invalid dari client

        $existing = $this->where('user_id', $userId)->where('video_id', $videoId)->first();

        $status = $percentage >= 95 ? 'selesai' : ($percentage > 0 ? 'sedang' : 'belum');

        if ($existing) {
            if ($percentage < (float) $existing->watch_percentage) {
                return;
            }
            $this->update($existing->id, [
                'watch_percentage' => $percentage,
                'status' => $status,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        } else {
            $this->insert([
                'user_id' => $userId,
                'video_id' => $videoId,
                'watch_percentage' => $percentage,
                'status' => $status,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }

    public function isBasicCourseComplete(int $userId, array $basicVideoIds): bool
    {
        if (empty($basicVideoIds)) {
            return false;
        }
        $selesaiCount = $this->where('user_id', $userId)
            ->whereIn('video_id', $basicVideoIds)
            ->where('status', 'selesai')
            ->countAllResults();
        return $selesaiCount >= count($basicVideoIds);
    }
}
