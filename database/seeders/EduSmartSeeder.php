<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Activity;
use App\Models\ApiKey;
use App\Models\Category;
use App\Models\EducationContent;
use App\Models\Journal;
use App\Models\Mood;
use App\Models\Role;
use App\Models\Statistic;
use App\Models\Streak;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class EduSmartSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();
        $educatorRole = Role::where('name', 'educator')->first();
        $userRole = Role::where('name', 'user')->first();

        $admin = User::updateOrCreate(
            ['email' => 'admin@mindlog.test'],
            [
                'role_id' => $adminRole?->id,
                'name' => 'Admin EduSmart',
                'password' => Hash::make('password'),
                'api_key' => User::generateApiKey(),
                'bio' => 'Pengelola MindLog EduSmart.',
            ]
        );

        $educator = User::updateOrCreate(
            ['email' => 'educator@mindlog.test'],
            [
                'role_id' => $educatorRole?->id,
                'name' => 'Educator Digital',
                'password' => Hash::make('password'),
                'api_key' => User::generateApiKey(),
                'bio' => 'Kontributor artikel literasi digital.',
            ]
        );

        $learner = User::updateOrCreate(
            ['email' => 'user@mindlog.test'],
            [
                'role_id' => $userRole?->id,
                'name' => 'Warga Belajar',
                'password' => Hash::make('password'),
                'api_key' => User::generateApiKey(),
                'bio' => 'Pengguna aktif jurnal belajar.',
            ]
        );

        foreach ([$admin, $educator, $learner] as $user) {
            Streak::firstOrCreate(['user_id' => $user->id]);
            ApiKey::firstOrCreate(
                ['user_id' => $user->id, 'name' => 'Default API Key'],
                ['key_hash' => hash('sha256', $user->api_key)]
            );
        }

        $categories = [
            ['name' => 'Literasi Digital', 'description' => 'Keamanan, etika, dan keterampilan digital dasar.', 'sdg_focus' => 'SDG 4 - Quality Education'],
            ['name' => 'Kebiasaan Belajar', 'description' => 'Strategi membangun rutinitas belajar harian.', 'sdg_focus' => 'SDG 4 - Quality Education'],
            ['name' => 'Produktivitas Warga', 'description' => 'Pemanfaatan TIK untuk kehidupan dan pekerjaan.', 'sdg_focus' => 'SDG 8 - Decent Work'],
            ['name' => 'Kesehatan Mental Belajar', 'description' => 'Refleksi, emosi, dan keseimbangan belajar.', 'sdg_focus' => 'SDG 3 - Good Health'],
        ];

        foreach ($categories as $categoryData) {
            Category::updateOrCreate(
                ['slug' => Str::slug($categoryData['name'])],
                $categoryData + ['slug' => Str::slug($categoryData['name']), 'is_active' => true]
            );
        }

        $literacy = Category::where('slug', 'literasi-digital')->first();
        $habit = Category::where('slug', 'kebiasaan-belajar')->first();
        $mental = Category::where('slug', 'kesehatan-mental-belajar')->first();

        $articles = [
            [
                'category_id' => $literacy?->id,
                'title' => 'Mengenali Hoaks dan Informasi Menyesatkan',
                'excerpt' => 'Panduan ringkas memeriksa sumber, tanggal, dan konteks informasi sebelum dibagikan.',
                'content' => "Literasi digital dimulai dari kebiasaan berhenti sejenak sebelum membagikan informasi. Periksa alamat situs, nama penulis, tanggal publikasi, dan bandingkan dengan sumber resmi. Jika judul terlalu provokatif atau meminta dibagikan segera, perlakukan sebagai sinyal untuk memverifikasi lebih dahulu.\n\nGunakan TIK secara cerdas dengan menyimpan sumber belajar tepercaya, mengikuti kanal edukasi, dan melaporkan konten yang merugikan masyarakat.",
                'estimated_minutes' => 6,
            ],
            [
                'category_id' => $habit?->id,
                'title' => 'Jurnal Harian untuk Membangun Kebiasaan Belajar',
                'excerpt' => 'Jurnal membantu pengguna melihat pola belajar dan menjaga konsistensi.',
                'content' => "Menulis jurnal harian membuat proses belajar lebih sadar. Catat apa yang dipelajari, durasi belajar, hambatan, dan satu langkah kecil untuk esok hari. Dalam beberapa minggu, catatan ini berubah menjadi data perkembangan yang bisa dievaluasi.\n\nMindLog EduSmart menggabungkan jurnal, statistik, dan artikel agar pengguna tidak hanya belajar, tetapi juga memahami kebiasaan belajarnya.",
                'estimated_minutes' => 5,
            ],
            [
                'category_id' => $mental?->id,
                'title' => 'Belajar Sehat dengan Refleksi Emosi',
                'excerpt' => 'Mood belajar yang tercatat membantu pengguna mengenali kapan perlu jeda.',
                'content' => "Belajar yang baik membutuhkan perhatian pada kondisi mental. Saat mood turun, kurangi target menjadi tugas kecil yang tetap bisa diselesaikan. Saat energi tinggi, gunakan momentum untuk materi yang lebih menantang.\n\nRefleksi emosi bukan pengganti bantuan profesional, tetapi dapat membantu pengguna mengenali pola harian dan menjaga kebiasaan belajar yang lebih manusiawi.",
                'estimated_minutes' => 4,
            ],
        ];

        foreach ($articles as $articleData) {
            Article::updateOrCreate(
                ['slug' => Str::slug($articleData['title'])],
                $articleData + [
                    'author_id' => $educator->id,
                    'slug' => Str::slug($articleData['title']),
                    'status' => 'published',
                    'read_count' => 12,
                    'published_at' => now()->subDays(7),
                ]
            );

            EducationContent::updateOrCreate(
                ['slug' => Str::slug($articleData['title'])],
                [
                    'user_id' => $educator->id,
                    'title' => $articleData['title'],
                    'type' => 'article',
                    'excerpt' => $articleData['excerpt'],
                    'content' => $articleData['content'],
                    'status' => 'published',
                    'read_count' => 12,
                    'estimated_minutes' => $articleData['estimated_minutes'],
                    'published_at' => now()->subDays(7),
                ]
            );
        }

        $mood = Mood::where('score', 4)->first();
        for ($i = 0; $i < 14; $i++) {
            Journal::updateOrCreate(
                ['user_id' => $learner->id, 'journal_date' => now()->subDays($i)->toDateString()],
                [
                    'mood_id' => $mood?->id,
                    'title' => 'Catatan Belajar Hari ' . ($i + 1),
                    'content' => 'Hari ini saya belajar literasi digital dan mencatat satu kebiasaan kecil untuk ditingkatkan.',
                    'daily_activities' => 'Membaca artikel, membuat rangkuman, dan latihan verifikasi informasi.',
                    'productivity_score' => min(100, 62 + ($i * 2)),
                    'activity_minutes' => 30 + ($i * 3),
                    'is_private' => true,
                ]
            );

            Activity::updateOrCreate(
                ['user_id' => $learner->id, 'activity_date' => now()->subDays($i)->toDateString(), 'title' => 'Belajar Literasi Digital'],
                [
                    'description' => 'Aktivitas belajar berbasis TIK yang dicatat untuk mengukur dampak.',
                    'category' => 'learning',
                    'duration_minutes' => 30 + ($i * 3),
                    'productivity_score' => min(100, 62 + ($i * 2)),
                ]
            );

            Statistic::updateOrCreate(
                ['user_id' => $learner->id, 'activity_date' => now()->subDays($i)->toDateString()],
                [
                    'journals_count' => 1,
                    'articles_read' => $i % 2 === 0 ? 2 : 1,
                    'learning_minutes' => 20 + ($i * 2),
                    'digital_literacy_score' => 65 + $i,
                    'metadata' => ['source' => 'seed'],
                ]
            );
        }
    }
}
