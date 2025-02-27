<?php

namespace Database\Factories;

use App\Models\Message;
use App\Models\MessageFile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MessageFile>
 */
class MessageFileFactory extends Factory
{
    protected $model = MessageFile::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'message_id' => Message::factory(),
            'file_path' => $this->faker->filePath(),
            'file_name' => $this->faker->word . '.pdf',
            'file_type' => $this->faker->mimeType,
        ];
    }
}
