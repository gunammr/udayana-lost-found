<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    private const PROGRAM_STUDI = [
        'Teknik Informatika',
        'Sistem Komputer',
        'Teknik Sipil',
        'Arsitektur',
        'Kedokteran Umum',
        'Ilmu Hukum',
        'Manajemen',
        'Akuntansi',
        'Ilmu Komunikasi',
        'Psikologi',
        'Biologi',
        'Kimia',
        'Matematika',
        'Fisika',
        'Agroteknologi',
    ];

    private const FAKULTAS_MAP = [
        'Teknik Informatika' => 'Teknik',
        'Sistem Komputer'    => 'Teknik',
        'Teknik Sipil'       => 'Teknik',
        'Arsitektur'         => 'Teknik',
        'Kedokteran Umum'    => 'Kedokteran',
        'Ilmu Hukum'         => 'Hukum',
        'Manajemen'          => 'Ekonomi dan Bisnis',
        'Akuntansi'          => 'Ekonomi dan Bisnis',
        'Ilmu Komunikasi'    => 'FISIP',
        'Psikologi'          => 'Kedokteran',
        'Biologi'            => 'MIPA',
        'Kimia'              => 'MIPA',
        'Matematika'         => 'MIPA',
        'Fisika'             => 'MIPA',
        'Agroteknologi'      => 'Pertanian',
    ];

    public function definition(): array
    {
        $prodi   = $this->faker->randomElement(self::PROGRAM_STUDI);
        $angkatan = (string) $this->faker->numberBetween(2020, 2024);
        $nim      = $angkatan . $this->faker->numerify('######');

        return [
            'name'             => $this->faker->name(),
            'avatar_path'      => $this->faker->boolean(60) 
                ? 'imagesdemo/' . $this->faker->randomElement([
                    'profilefemale1.png', 'profilefemale2.png', 
                    'profilemale1.png', 'profilemale2.png'
                ]) 
                : null,
            'email'            => $this->faker->unique()->safeEmail(),
            'email_verified_at'=> now(),
            'password'         => static::$password ??= Hash::make('password'),
            'remember_token'   => Str::random(10),
            'phone'            => $this->faker->numerify('08##########'),
            'role'             => 'user',
            'nim'              => $nim,
            'tahun_angkatan'   => $angkatan,
            'program_studi'    => $prodi,
            'fakultas'         => self::FAKULTAS_MAP[$prodi],
            'bio'              => $this->faker->boolean(50)
                ? 'Mahasiswa ' . $prodi . ' angkatan ' . $angkatan . ' Universitas Udayana.'
                : null,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * State: admin user
     */
    public function admin(): static
    {
        return $this->state(fn () => ['role' => 'admin']);
    }
}
