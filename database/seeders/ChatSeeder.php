<?php

namespace Database\Seeders;

use App\Models\Conversation;
use App\Models\ConversationParticipant;
use App\Models\Message;
use App\Models\MessageFile;
use App\Models\User;
use Illuminate\Database\Seeder;

class ChatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::factory(15)->create();
        $alreadyUsers = [];

        Conversation::factory(12)->create()->each(function ($conversation) use ($users, &$alreadyUsers) {
            $participants = collect([1]);
            $randomUser = $users->reject(fn($user) => in_array($user->id, $alreadyUsers) || $user->id == 1)->random(1)->first();
            if ($randomUser) {
                $alreadyUsers[] = $randomUser->id;
                $participants->push($randomUser->id);
            }

            foreach ($participants as $userId) {
                ConversationParticipant::factory()->create([
                    'conversation_id' => $conversation->id,
                    'user_id' => $userId,
                ]);
            }

            Message::factory(rand(4, 50))->create([
                'conversation_id' => $conversation->id,
                'sender_id' => $participants->random(),
            ])->each(function ($message) {
                if (rand(0, 1)) {
                    MessageFile::factory(rand(1, 2))->create([
                        'message_id' => $message->id,
                    ]);
                }
            });
        });
    }
}
