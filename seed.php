<?php
$u = 4;
\App\Models\Journal::where('user_id', $u)->delete();
for ($i = 1; $i <= 10; $i++) {
    \App\Models\Journal::create([
        'user_id' => $u,
        'title' => 'Catatan Refleksi ' . $i,
        'content' => 'Hari ini saya mempelajari banyak hal baru. Sangat menarik bagaimana proses belajar ini berjalan. Meskipun awalnya bingung, akhirnya mulai paham.',
        'journal_date' => now()->subDays(rand(2, 45)),
        'mood_id' => rand(1, 3),
        'is_private' => true
    ]);
}
echo "Seeded 10 journals\n";
