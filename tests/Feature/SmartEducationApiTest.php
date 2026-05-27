<?php

namespace Tests\Feature;

use App\Models\Mood;
use App\Models\Role;
use App\Models\User;
use Database\Seeders\MoodSeeder;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SmartEducationApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);
        $this->seed(MoodSeeder::class);
    }

    public function test_user_can_create_journal_and_view_measured_impact(): void
    {
        $user = $this->userWithRole('user');
        $token = $this->loginToken($user);
        $mood = Mood::firstOrFail();

        $this->withToken($token)->postJson('/api/journals', [
            'mood_id' => $mood->id,
            'title' => 'Belajar keamanan digital',
            'content' => 'Saya mempraktikkan verifikasi informasi sebelum membagikan berita.',
            'daily_activities' => 'Membaca artikel edukasi dan membuat catatan refleksi.',
            'productivity_score' => 82,
            'activity_minutes' => 45,
            'journal_date' => now()->toDateString(),
            'is_private' => true,
        ])->assertCreated();

        $this->withToken($token)
            ->getJson('/api/statistics')
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonStructure(['data' => ['total_journal', 'average_productivity', 'weekly_mood']]);

        $this->withToken($token)
            ->getJson('/api/impact')
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonStructure(['data' => ['metric', 'message', 'productivity_improved_percentage']]);

        $this->withToken($token)
            ->getJson('/api/leaderboard')
            ->assertOk()
            ->assertJsonStructure(['data' => ['most_active_users', 'most_journals', 'most_consistent']]);
    }

    public function test_educator_can_create_education_content(): void
    {
        $educator = $this->userWithRole('educator');
        $token = $this->loginToken($educator);

        $this->withToken($token)->postJson('/api/education', [
            'title' => 'Tips produktivitas belajar digital',
            'type' => 'tip',
            'excerpt' => 'Langkah singkat untuk belajar lebih konsisten.',
            'content' => 'Gunakan jurnal harian, evaluasi aktivitas, dan baca sumber tepercaya.',
            'status' => 'published',
            'estimated_minutes' => 4,
        ])->assertCreated()
            ->assertJsonPath('success', true);

        $this->withToken($token)
            ->getJson('/api/education')
            ->assertOk()
            ->assertJsonPath('success', true);
    }

    private function userWithRole(string $roleName): User
    {
        return User::factory()->create([
            'role_id' => Role::where('name', $roleName)->value('id'),
            'password' => Hash::make('password'),
        ]);
    }

    private function loginToken(User $user): string
    {
        return $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertOk()->json('data.access_token');
    }
}
