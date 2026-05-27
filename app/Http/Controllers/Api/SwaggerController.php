<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use OpenApi\Annotations as OA;
use OpenApi\Attributes as OAT;

/**
 * @OA\Info(
 *     title="MindLog EduSmart API",
 *     version="1.0.0",
 *     description="API jurnal, artikel edukasi, kategori pembelajaran, literasi digital, dan statistik dampak penggunaan."
 * )
 * @OA\Server(url="/", description="Local server")
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 * @OA\SecurityScheme(
 *     securityScheme="basicAuth",
 *     type="http",
 *     scheme="basic"
 * )
 * @OA\SecurityScheme(
 *     securityScheme="apiKeyAuth",
 *     type="apiKey",
 *     in="header",
 *     name="X-API-Key"
 * )
 */
#[OAT\Info(
    version: '1.0.0',
    title: 'MindLog EduSmart API',
    description: 'API jurnal, artikel edukasi, kategori pembelajaran, literasi digital, dan statistik dampak penggunaan.'
)]
#[OAT\Server(url: '/', description: 'Local server')]
#[OAT\SecurityScheme(securityScheme: 'bearerAuth', type: 'http', scheme: 'bearer', bearerFormat: 'JWT')]
#[OAT\SecurityScheme(securityScheme: 'basicAuth', type: 'http', scheme: 'basic')]
#[OAT\SecurityScheme(securityScheme: 'apiKeyAuth', type: 'apiKey', in: 'header', name: 'X-API-Key')]
class SwaggerController extends Controller
{
    #[OAT\Post(
        path: '/api/register',
        tags: ['Auth'],
        summary: 'Register user baru',
        requestBody: new OAT\RequestBody(
            required: true,
            content: new OAT\JsonContent(
                required: ['name', 'email', 'password', 'password_confirmation'],
                properties: [
                    new OAT\Property(property: 'name', type: 'string', example: 'Warga Belajar'),
                    new OAT\Property(property: 'email', type: 'string', example: 'user@mindlog.test'),
                    new OAT\Property(property: 'password', type: 'string', example: 'password123'),
                    new OAT\Property(property: 'password_confirmation', type: 'string', example: 'password123'),
                ]
            )
        ),
        responses: [new OAT\Response(response: 201, description: 'Registrasi berhasil')]
    )]
    #[OAT\Post(
        path: '/api/login',
        tags: ['Auth'],
        summary: 'Login dan mendapatkan JWT',
        requestBody: new OAT\RequestBody(
            required: true,
            content: new OAT\JsonContent(
                required: ['email', 'password'],
                properties: [
                    new OAT\Property(property: 'email', type: 'string', example: 'admin@mindlog.test'),
                    new OAT\Property(property: 'password', type: 'string', example: 'password'),
                ]
            )
        ),
        responses: [new OAT\Response(response: 200, description: 'Login berhasil')]
    )]
    #[OAT\Post(path: '/api/logout', tags: ['Auth'], summary: 'Logout JWT', security: [['bearerAuth' => []]], responses: [new OAT\Response(response: 200, description: 'Logout berhasil')])]
    #[OAT\Get(path: '/api/profile', tags: ['Auth'], summary: 'Profil user login', security: [['bearerAuth' => []]], responses: [new OAT\Response(response: 200, description: 'Profil user')])]
    #[OAT\Get(path: '/api/journals', tags: ['Journal'], summary: 'Daftar jurnal user', security: [['bearerAuth' => []]], responses: [new OAT\Response(response: 200, description: 'Daftar jurnal')])]
    #[OAT\Post(
        path: '/api/journals',
        tags: ['Journal'],
        summary: 'Tambah jurnal',
        security: [['bearerAuth' => []]],
        requestBody: new OAT\RequestBody(
            required: true,
            content: new OAT\JsonContent(
                required: ['mood_id', 'title', 'content', 'journal_date'],
                properties: [
                    new OAT\Property(property: 'mood_id', type: 'integer', example: 4),
                    new OAT\Property(property: 'title', type: 'string', example: 'Belajar Literasi Digital'),
                    new OAT\Property(property: 'content', type: 'string', example: 'Saya membaca artikel keamanan digital.'),
                    new OAT\Property(property: 'journal_date', type: 'string', example: '2026-05-27'),
                    new OAT\Property(property: 'is_private', type: 'boolean', example: true),
                ]
            )
        ),
        responses: [new OAT\Response(response: 201, description: 'Jurnal dibuat')]
    )]
    #[OAT\Get(path: '/api/journals/{id}', tags: ['Journal'], summary: 'Detail jurnal', security: [['bearerAuth' => []]], parameters: [new OAT\Parameter(name: 'id', in: 'path', required: true, schema: new OAT\Schema(type: 'integer'))], responses: [new OAT\Response(response: 200, description: 'Detail jurnal')])]
    #[OAT\Put(path: '/api/journals/{id}', tags: ['Journal'], summary: 'Update jurnal', security: [['bearerAuth' => []]], parameters: [new OAT\Parameter(name: 'id', in: 'path', required: true, schema: new OAT\Schema(type: 'integer'))], responses: [new OAT\Response(response: 200, description: 'Jurnal diperbarui')])]
    #[OAT\Delete(path: '/api/journals/{id}', tags: ['Journal'], summary: 'Hapus jurnal', security: [['bearerAuth' => []]], parameters: [new OAT\Parameter(name: 'id', in: 'path', required: true, schema: new OAT\Schema(type: 'integer'))], responses: [new OAT\Response(response: 200, description: 'Jurnal dihapus')])]
    #[OAT\Get(path: '/api/articles', tags: ['Article'], summary: 'Daftar artikel edukasi', security: [['bearerAuth' => []]], responses: [new OAT\Response(response: 200, description: 'Daftar artikel')])]
    #[OAT\Post(path: '/api/articles', tags: ['Article'], summary: 'Tambah artikel', security: [['bearerAuth' => []]], responses: [new OAT\Response(response: 201, description: 'Artikel dibuat')])]
    #[OAT\Get(path: '/api/articles/{id}', tags: ['Article'], summary: 'Detail artikel', security: [['bearerAuth' => []]], parameters: [new OAT\Parameter(name: 'id', in: 'path', required: true, schema: new OAT\Schema(type: 'integer'))], responses: [new OAT\Response(response: 200, description: 'Detail artikel')])]
    #[OAT\Put(path: '/api/articles/{id}', tags: ['Article'], summary: 'Update artikel', security: [['bearerAuth' => []]], parameters: [new OAT\Parameter(name: 'id', in: 'path', required: true, schema: new OAT\Schema(type: 'integer'))], responses: [new OAT\Response(response: 200, description: 'Artikel diperbarui')])]
    #[OAT\Delete(path: '/api/articles/{id}', tags: ['Article'], summary: 'Hapus artikel', security: [['bearerAuth' => []]], parameters: [new OAT\Parameter(name: 'id', in: 'path', required: true, schema: new OAT\Schema(type: 'integer'))], responses: [new OAT\Response(response: 200, description: 'Artikel dihapus')])]
    #[OAT\Get(path: '/api/categories', tags: ['Category'], summary: 'Daftar kategori', security: [['bearerAuth' => []]], responses: [new OAT\Response(response: 200, description: 'Daftar kategori')])]
    #[OAT\Post(path: '/api/categories', tags: ['Category'], summary: 'Tambah kategori', security: [['bearerAuth' => []]], responses: [new OAT\Response(response: 201, description: 'Kategori dibuat')])]
    #[OAT\Get(path: '/api/categories/{id}', tags: ['Category'], summary: 'Detail kategori', security: [['bearerAuth' => []]], parameters: [new OAT\Parameter(name: 'id', in: 'path', required: true, schema: new OAT\Schema(type: 'integer'))], responses: [new OAT\Response(response: 200, description: 'Detail kategori')])]
    #[OAT\Put(path: '/api/categories/{id}', tags: ['Category'], summary: 'Update kategori', security: [['bearerAuth' => []]], parameters: [new OAT\Parameter(name: 'id', in: 'path', required: true, schema: new OAT\Schema(type: 'integer'))], responses: [new OAT\Response(response: 200, description: 'Kategori diperbarui')])]
    #[OAT\Delete(path: '/api/categories/{id}', tags: ['Category'], summary: 'Hapus kategori', security: [['bearerAuth' => []]], parameters: [new OAT\Parameter(name: 'id', in: 'path', required: true, schema: new OAT\Schema(type: 'integer'))], responses: [new OAT\Response(response: 200, description: 'Kategori dihapus')])]
    #[OAT\Get(path: '/api/statistics', tags: ['Statistics'], summary: 'Statistik pengguna', security: [['bearerAuth' => []]], responses: [new OAT\Response(response: 200, description: 'Statistik pengguna')])]
    #[OAT\Get(path: '/api/basic/statistics', tags: ['Authorization'], summary: 'Contoh Basic Auth', security: [['basicAuth' => []]], responses: [new OAT\Response(response: 200, description: 'Statistik dengan Basic Auth')])]
    #[OAT\Get(path: '/api/key/articles', tags: ['Authorization'], summary: 'Contoh API Key', security: [['apiKeyAuth' => []]], responses: [new OAT\Response(response: 200, description: 'Artikel dengan API Key')])]
    public function documentationExamples(): void
    {
    }
}
